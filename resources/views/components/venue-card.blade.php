@props(['venue' => null, 'image' => null, 'name' => null, 'rating' => null, 'sport' => null, 'location' => null, 'price' => 0, 'url' => null])

@php
    if ($venue) {
        $image = $venue->logo_url ?? ($image ?? 'https://via.placeholder.com/400x500');
        $name = $venue->name ?? $name;
        $rating = $venue->rating_avg ?? $rating;
        $sport = optional($venue->sportsCategories->first())->name ?? $sport;
        $location = $venue->city ?? $location;
        $price = $price ?? 0;
        $url = $venue->slug ? route('venues.show', $venue->slug) : ($url ?? '#');
    }
@endphp

<x-molecules.cards.venue :image="$image" :name="$name" :rating="$rating" :sport="$sport" :location="$location" :price="$price" :url="$url" />
