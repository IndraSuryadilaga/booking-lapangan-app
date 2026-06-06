<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingSlot;
use App\Models\Field;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::where('role', 'user')->pluck('id');
        $fieldIds = Field::pluck('id');

        if ($userIds->isEmpty() || $fieldIds->isEmpty()) {
            $this->command->error('Users atau Fields kosong! Silakan seed terlebih dahulu.');
            return;
        }

        $totalBookings = 500;

        $this->command->info("Men-generate {$totalBookings} data Booking beserta Slot yang akurat...");

        Booking::factory($totalBookings)
            ->state(function () use ($userIds, $fieldIds) {
                $statuses = ['pending', 'paid', 'completed', 'cancelled', 'expired'];
                $status = (rand(0, 100) < 70) ? 'completed' : $statuses[array_rand($statuses)];

                $bookingDate = fake()->dateTimeBetween('-1 year', '+1 month')->format('Y-m-d'); // Default range

                if ($status === 'completed') {
                    $bookingDate = fake()->dateTimeBetween('-1 year', 'yesterday')->format('Y-m-d');
                } elseif (in_array($status, ['pending', 'paid'])) {
                    $bookingDate = fake()->dateTimeBetween('today', '+2 months')->format('Y-m-d');
                }

                return [
                    'user_id' => $userIds->random(),
                    'field_id' => $fieldIds->random(),
                    'status' => $status,
                    'booking_date' => $bookingDate,
                ];
            })
            ->create()
            ->each(function ($booking) {
                $numSlots = rand(1, 3);
                $totalPrice = 0;
                $slotsData = [];

                $startHour = rand(8, 18);

                for ($i = 0; $i < $numSlots; $i++) {
                    $slotPrice = rand(5, 15) * 10000;
                    $totalPrice += $slotPrice;

                    $slotsData[] = [
                        'booking_id' => $booking->id,
                        'field_id' => $booking->field_id,
                        'booking_date' => $booking->booking_date,
                        'start_time' => sprintf('%02d:00:00', $startHour + $i),
                        'end_time' => sprintf('%02d:00:00', $startHour + $i + 1),
                        'price' => $slotPrice,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                BookingSlot::insert($slotsData);

                $booking->update([
                    'total_slots' => $numSlots,
                    'total_price' => $totalPrice,
                ]);
            });

        $this->command->info('Seeding Transaksi (Booking & Slots) berhasil tanpa error relasi!');
    }
}
