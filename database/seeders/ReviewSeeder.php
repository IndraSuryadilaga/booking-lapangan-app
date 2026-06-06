<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookingsToReview = Booking::where('status', 'completed')
                                   ->whereDoesntHave('review')
                                   ->get();

        if ($bookingsToReview->isEmpty()) {
            $this->command->info('Tidak ada booking yang perlu di-review. Seeder Review dilewati.');
            return;
        }

        $this->command->info("Men-generate " . $bookingsToReview->count() . " data Review untuk booking yang telah selesai...");

        foreach ($bookingsToReview as $booking) {
            Review::factory()
                ->create([
                    'user_id'    => $booking->user_id,
                    'venue_id'   => $booking->field->venue_id,
                    'field_id'   => $booking->field_id,
                    'booking_id' => $booking->id,
                ]);
        }

        $this->command->info('Seeding Review selesai dengan integritas relasi 100% aman!');
    }
}
