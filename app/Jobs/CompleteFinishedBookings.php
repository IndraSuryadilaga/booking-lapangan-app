<?php

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompleteFinishedBookings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Running CompleteFinishedBookings job...');

        $latestSlots = DB::table('booking_slots')
            ->select('booking_id', DB::raw('MAX(end_time) as latest_end_time'), DB::raw('MAX(booking_date) as latest_booking_date'))
            ->groupBy('booking_id');

        $completedCount = Booking::query()
            ->joinSub($latestSlots, 'latest_slots', function ($join) {
                $join->on('bookings.id', '=', 'latest_slots.booking_id');
            })
            ->where('bookings.status', 'paid')
            ->where(function ($query) {
                $query->where('latest_slots.latest_booking_date', '<', today())
                    ->orWhere(function ($query) {
                        $query->where('latest_slots.latest_booking_date', '=', today())
                              ->where('latest_slots.latest_end_time', '<', now()->format('H:i:s'));
                    });
            })
            ->update(['bookings.status' => 'completed']);

        Log::info("Completed {$completedCount} finished bookings.");
    }
}
