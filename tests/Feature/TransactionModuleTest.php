<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TransactionModuleTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function public_holidays_table_can_be_created()
    {
        $this->assertTrue(
            \Schema::hasTable('public_holidays')
        );

        $this->assertTrue(
            \Schema::hasColumns('public_holidays', [
                'id', 'name', 'date', 'created_at', 'updated_at'
            ])
        );
    }

    #[Test]
    public function bookings_table_can_be_created()
    {
        $this->assertTrue(
            \Schema::hasTable('bookings')
        );

        $this->assertTrue(
            \Schema::hasColumns('bookings', [
                'id', 'user_id', 'field_id', 'booking_date', 'total_slots', 'total_price', 'status', 'notes', 'expires_at', 'created_at', 'updated_at'
            ])
        );
    }

    #[Test]
    public function booking_slots_table_can_be_created()
    {
        $this->assertTrue(
            \Schema::hasTable('booking_slots')
        );

        $this->assertTrue(
            \Schema::hasColumns('booking_slots', [
                'id', 'booking_id', 'start_time', 'end_time', 'price', 'created_at', 'updated_at'
            ])
        );
    }

    #[Test]
    public function payments_table_can_be_created()
    {
        $this->assertTrue(
            \Schema::hasTable('payments')
        );

        $this->assertTrue(
            \Schema::hasColumns('payments', [
                'id', 'booking_id', 'amount', 'method', 'status', 'paid_at', 'reference_code', 'created_at', 'updated_at'
            ])
        );
    }

    #[Test]
    public function reviews_table_can_be_created()
    {
        $this->assertTrue(
            \Schema::hasTable('reviews')
        );

        $this->assertTrue(
            \Schema::hasColumns('reviews', [
                'id', 'user_id', 'venue_id', 'booking_id', 'rating', 'comment', 'created_at', 'updated_at'
            ])
        );
    }
}
