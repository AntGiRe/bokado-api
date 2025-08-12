<?php

namespace App\Services\Locations;

use App\Models\City;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CityService
{
    /**
     * Get all cities with optional filters.
     */
    public function getAllCities(array $filters = []): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        $query = City::with([
            'province.translations',
            'province.region.translations',
            'province.region.country.translations',
            'translations'
        ]);

        // Filtrar por provincia (ID o código)
        if (!empty($filters['province-id'])) {
            if (is_numeric($filters['province-id'])) {
                $query->where('province_id', $filters['province-id']);
            } else {
                $query->whereHas('province', function ($q) use ($filters) {
                    $q->where('code', $filters['province-id']);
                });
            }
        }

        // Filtrar por región
        if (!empty($filters['region-id'])) {
            if (is_numeric($filters['region-id'])) {
                $query->whereHas('province', function ($q) use ($filters) {
                    $q->where('region_id', $filters['region-id']);
                });
            } else {
                $query->whereHas('province.region', function ($q) use ($filters) {
                    $q->where('code', $filters['region-id']);
                });
            }
        }

        // Filtrar por país
        if (!empty($filters['country-id'])) {
            if (is_numeric($filters['country-id'])) {
                $query->whereHas('province.region', function ($q) use ($filters) {
                    $q->where('country_id', $filters['country-id']);
                });
            } else {
                $query->whereHas('province.region.country', function ($q) use ($filters) {
                    $q->where('code', $filters['country']);
                });
            }
        }

        // Filtrar por ciudad (ID, código o nombre traducido)
        if (!empty($filters['city'])) {
            $query->where(function ($q) use ($filters, $locale) {
                // Buscar por ID
                if (is_numeric($filters['city'])) {
                    $q->where('id', $filters['city']);
                }
                // Buscar por código
                $q->orWhere('code', 'like', '%' . $filters['city'] . '%')
                    // Buscar por nombre traducido
                    ->orWhereHas('translations', function ($tq) use ($filters, $locale) {
                        $tq->where('locale', $locale)
                            ->where('name', 'like', '%' . $filters['city'] . '%');
                    });
            });
        }

        return $query->select(['id', 'code', 'province_id'])
            ->orderBy('code')
            ->paginate(50)
            ->through(function (City $city) {
                return [
                    'id' => $city->id,
                    'code' => $city->code,
                    'name' => $city->translated_name,
                    'province' => [
                        'id' => $city->province->id,
                        'code' => $city->province->code,
                        'name' => $city->province->translated_name,
                        'region' => [
                            'id' => $city->province->region->id,
                            'code' => $city->province->region->code,
                            'name' => $city->province->region->translated_name,
                            'country' => [
                                'id' => $city->province->region->country->id,
                                'code' => $city->province->region->country->code,
                                'name' => $city->province->region->country->translated_name,
                            ]
                        ]
                    ]
                ];
            });
    }

    /**
     * Get city with all related data.
     */
    public function getCityWithRelations(City $city): array
    {
        $city->load([
            'province.translations',
            'province.region.translations',
            'province.region.country.translations',
            'restaurants',
            'translations'
        ])->loadCount(['restaurants as active_restaurants_count' => function ($query) {
            $query->where('is_active', true);
        }]);

        return [
            'id' => $city->id,
            'code' => $city->code,
            'name' => $city->translated_name,
            'province' => [
                'id' => $city->province->id,
                'code' => $city->province->code,
                'name' => $city->province->translated_name,
                'region' => [
                    'id' => $city->province->region->id,
                    'code' => $city->province->region->code,
                    'name' => $city->province->region->translated_name,
                    'country' => [
                        'id' => $city->province->region->country->id,
                        'code' => $city->province->region->country->code,
                        'name' => $city->province->region->country->translated_name,
                    ]
                ]
            ],
            'restaurants_count' => $city->active_restaurants_count,
        ];
    }
}
