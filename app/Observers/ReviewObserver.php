<?php

namespace App\Observers;

use App\Models\Review;
use App\Models\Venue;

class ReviewObserver
{
    public function created(Review $review): void
    {
        $this->updateVenueRating($review->venue_id);
    }

    public function updated(Review $review): void
    {
        $this->updateVenueRating($review->venue_id);
    }

    private function updateVenueRating(int $venueId): void
    {
        $venue = Venue::find($venueId);

        if (! $venue) {
            return;
        }

        $avg = $venue->reviews()->avg('rating') ?? 0;
        $count = $venue->reviews()->count();

        $venue->update([
            'rating_avg' => $avg,
            'review_count' => $count,
        ]);
    }
}
