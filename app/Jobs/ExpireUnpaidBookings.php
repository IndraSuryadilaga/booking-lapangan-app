<?php

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExpireUnpaidBookings implements ShouldQueue
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
        Log::info('Running ExpireUnpaidBookings job...');

        $expiredCount = 0;
        Booking::where('status', 'pending')
            ->where('expires_at', '<', now())
            ->with('slots') // Eager load slots to avoid N+1 queries
            ->each(function (Booking $booking) use (&$expiredCount) {
                 DB::transaction(function () use ($booking) {
                    $booking->slots()->delete();

                    $booking->update(['status' => 'expired']);
                 });
                $expiredCount++;
            });

        Log::info("Expired {$expiredCount} unpaid bookings.");
    }
}
