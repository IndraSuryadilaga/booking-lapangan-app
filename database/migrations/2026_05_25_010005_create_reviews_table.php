<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('venue_id')->constrained()->onDelete('cascade');
            $table->foreignId('field_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('set null');
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        // Trigger untuk memperbarui rating_avg dan review_count di tabel venues setelah insert
        DB::unprepared('
            CREATE TRIGGER update_venue_rating_after_insert
            AFTER INSERT ON reviews
            FOR EACH ROW
            BEGIN
                UPDATE venues
                SET 
                    rating_avg = (SELECT AVG(rating) FROM reviews WHERE venue_id = NEW.venue_id),
                    review_count = (SELECT COUNT(*) FROM reviews WHERE venue_id = NEW.venue_id)
                WHERE id = NEW.venue_id;
            END;
        ');

        // Trigger untuk memperbarui rating_avg dan review_count di tabel venues setelah delete
        DB::unprepared('
            CREATE TRIGGER update_venue_rating_after_delete
            AFTER DELETE ON reviews
            FOR EACH ROW
            BEGIN
                UPDATE venues
                SET 
                    rating_avg = IFNULL((SELECT AVG(rating) FROM reviews WHERE venue_id = OLD.venue_id), 0),
                    review_count = (SELECT COUNT(*) FROM reviews WHERE venue_id = OLD.venue_id)
                WHERE id = OLD.venue_id;
            END;
        ');

        // Trigger untuk memperbarui rating_avg di tabel venues setelah update rating
        DB::unprepared('
            CREATE TRIGGER update_venue_rating_after_update
            AFTER UPDATE ON reviews
            FOR EACH ROW
            BEGIN
                IF OLD.rating <> NEW.rating THEN
                    UPDATE venues
                    SET rating_avg = (SELECT AVG(rating) FROM reviews WHERE venue_id = NEW.venue_id)
                    WHERE id = NEW.venue_id;
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_venue_rating_after_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS update_venue_rating_after_delete');
        DB::unprepared('DROP TRIGGER IF EXISTS update_venue_rating_after_update');
        Schema::dropIfExists('reviews');
    }
};