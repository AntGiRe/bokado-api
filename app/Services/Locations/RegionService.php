<?php

namespace App\Services\Locations;

use App\Models\Region;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RegionService
{
    /**
     * Get all regions with optional filters.
     */
    public function getAllRegions(array $filters = []): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        $query = Region::with(['country.translations', 'translations']);

        // Filtrar por país (ID o código)
        if (!empty($filters['country-id'])) {
            if (is_numeric($filters['country-id'])) {
                $query->where('country_id', $filters['country-id']);
            } else {
                $query->whereHas('country', function ($q) use ($filters) {
                    $q->where('code', $filters['country']);
                });
            }
        }

        // Filtrar por ID, código o nombre de región
        if (!empty($filters['region'])) {
            $query->where(function ($q) use ($filters, $locale) {
                // Buscar por ID si es numérico
                if (is_numeric($filters['region'])) {
                    $q->where('id', $filters['region']);
                }
                // Buscar por código
                $q->orWhere('code', 'like', '%' . $filters['region'] . '%')
                  // Buscar por nombre traducido
                  ->orWhereHas('translations', function ($tq) use ($filters, $locale) {
                      $tq->where('locale', $locale)
                         ->where('name', 'like', '%' . $filters['region'] . '%');
                  });
            });
        }

        return $query->select(['id', 'code', 'country_id'])
            ->orderBy('code')
            ->paginate(50)
            ->through(function (Region $region) {
                return [
                    'id' => $region->id,
                    'code' => $region->code,
                    'name' => $region->translated_name,
                    'country' => [
                        'id' => $region->country->id,
                        'code' => $region->country->code,
                        'name' => $region->country->translated_name,
                    ]
                ];
            });
    }

    /**
     * Get region with all related data.
     */
    public function getRegionWithRelations(Region $region): array
    {
        $region->load(['country.translations', 'provinces.translations', 'translations']);

        return [
            'id' => $region->id,
            'code' => $region->code,
            'name' => $region->translated_name,
            'country' => [
                'id' => $region->country->id,
                'code' => $region->country->code,
                'name' => $region->country->translated_name,
            ]
        ];
    }
}
