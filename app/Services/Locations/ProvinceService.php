<?php

namespace App\Services\Locations;

use App\Models\Province;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProvinceService
{
    /**
     * Get all provinces with optional filters.
     */
    public function getAllProvinces(array $filters = []): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        $query = Province::with(['region.translations', 'region.country.translations', 'translations']);

        // Filtrar por región (ID o código)
        if (!empty($filters['region-id'])) {
            if (is_numeric($filters['region-id'])) {
                $query->where('region_id', $filters['region-id']);
            } else {
                $query->whereHas('region', function ($q) use ($filters) {
                    $q->where('code', $filters['region-id']);
                });
            }
        }

        // Filtrar por país
        if (!empty($filters['country-id'])) {
            if (is_numeric($filters['country-id'])) {
                $query->whereHas('region', function ($q) use ($filters) {
                    $q->where('country_id', $filters['country-id']);
                });
            } else {
                $query->whereHas('region.country', function ($q) use ($filters) {
                    $q->where('code', $filters['country-id']);
                });
            }
        }

        // Filtrar por nombre/código de provincia
        if (!empty($filters['province'])) {
            $query->where(function ($q) use ($filters, $locale) {
                // Buscar por ID si es numérico
                if (is_numeric($filters['province'])) {
                    $q->where('id', $filters['province']);
                }
                // Buscar por código
                $q->orWhere('code', 'like', '%' . $filters['province'] . '%')
                    // Buscar por nombre traducido
                    ->orWhereHas('translations', function ($tq) use ($filters, $locale) {
                        $tq->where('locale', $locale)
                            ->where('name', 'like', '%' . $filters['province'] . '%');
                    });
            });
        }

        return $query->select(['id', 'code', 'region_id'])
            ->orderBy('code')
            ->paginate(50)
            ->through(function (Province $province) {
                return [
                    'id' => $province->id,
                    'code' => $province->code,
                    'name' => $province->translated_name,
                    'region' => [
                        'id' => $province->region->id,
                        'code' => $province->region->code,
                        'name' => $province->region->translated_name,
                        'country' => [
                            'id' => $province->region->country->id,
                            'code' => $province->region->country->code,
                            'name' => $province->region->country->translated_name,
                        ]
                    ]
                ];
            });
    }

    /**
     * Get province with all related data.
     */
    public function getProvinceWithRelations(Province $province): array
    {
        $province->load([
            'region.translations',
            'region.country.translations',
            'cities.translations',
            'translations'
        ]);

        return [
            'id' => $province->id,
            'code' => $province->code,
            'name' => $province->translated_name,
            'region' => [
                'id' => $province->region->id,
                'code' => $province->region->code,
                'name' => $province->region->translated_name,
                'country' => [
                    'id' => $province->region->country->id,
                    'code' => $province->region->country->code,
                    'name' => $province->region->country->translated_name,
                ]
            ]
        ];
    }
}
