<?php

namespace App\Services;

use App\Models\SportsCategory;
use App\Models\Venue;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class VenueFilterService
{
    public function getCities(): Collection
    {
        return Venue::query()
            ->distinct()
            ->orderBy('city')
            ->pluck('city')
            ->filter()
            ->values();
    }

    public function getActiveCategories(): Collection
    {
        return SportsCategory::where('is_active', true)->orderBy('name')->get();
    }

    public function getCategoryOptions(Collection $categories, string $emptyLabel = 'Semua Kategori'): array
    {
        $options = [['value' => '', 'label' => $emptyLabel]];

        foreach ($categories as $category) {
            $options[] = ['value' => $category->id, 'label' => $category->name];
        }

        return $options;
    }

    public function getCityOptions(Collection $cities, string $emptyLabel = 'Semua Kota'): array
    {
        $options = [['value' => '', 'label' => $emptyLabel]];

        foreach ($cities as $city) {
            $options[] = ['value' => $city, 'label' => $city];
        }

        return $options;
    }

    public function parseFilters(Request $request): array
    {
        $categories = $request->input('category', []);

        if (! is_array($categories)) {
            $categories = [$categories];
        }

        $categories = array_values(array_filter(
            $categories,
            fn ($id) => $id !== '' && $id !== null
        ));

        return [
            'search' => trim((string) $request->input('search', '')),
            'city' => trim((string) $request->input('city', '')),
            'categories' => $categories,
        ];
    }

    public function getSelectedCategory(array $filters): string
    {
        return (string) ($filters['categories'][0] ?? '');
    }

    public function applyFilters(Builder $query, array $filters): Builder
    {
        if ($filters['search'] !== '') {
            $query->where('name', 'like', '%'.$filters['search'].'%');
        }

        if ($filters['city'] !== '') {
            $query->where('city', $filters['city']);
        }

        if (! empty($filters['categories'])) {
            $query->whereHas('fields', function ($q) use ($filters) {
                $q->whereIn('sports_category_id', $filters['categories']);
            });
        }

        return $query;
    }

    public function filterVenues(Request $request, int $perPage = 12): LengthAwarePaginator
    {
        $filters = $this->parseFilters($request);

        $query = Venue::query()
            ->with([
                'fieldSportCategories',
                'facilities',
                'fields.pricings',
            ]);

        $this->applyFilters($query, $filters);

        return $query->paginate($perPage)->withQueryString();
    }
}
