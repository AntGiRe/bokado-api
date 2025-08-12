<?php

namespace App\Services\Locations;

use App\Models\TouristicRegion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TouristicRegionService
{
    /**
     * Get all touristic regions with optional filters.
     */
    public function getAllTouristicRegions(array $filters = []): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        $query = TouristicRegion::with('translations');

        // Filtrar por ID o nombre de zona turística
        if (!empty($filters['touristic_region'])) {
            $query->where(function ($q) use ($filters, $locale) {
                // Buscar por ID si es numérico
                if (is_numeric($filters['touristic_region'])) {
                    $q->where('id', $filters['touristic_region']);
                }
                // Buscar por código
                $q->orWhere('code', 'like', '%' . $filters['touristic_region'] . '%')
                  // Buscar por nombre traducido
                  ->orWhereHas('translations', function ($tq) use ($filters, $locale) {
                      $tq->where('locale', $locale)
                         ->where('name', 'like', '%' . $filters['touristic_region'] . '%');
                  });
            });
        }

        return $query->select(['id', 'code'])
            ->orderBy('code')
            ->paginate(50)
            ->through(function (TouristicRegion $touristicRegion) {
                return [
                    'id' => $touristicRegion->id,
                    'code' => $touristicRegion->code,
                    'name' => $touristicRegion->translated_name,
                ];
            });
    }

    /**
     * Get touristic region with all related data.
     */
    public function getTouristicRegionWithRelations(TouristicRegion $touristicRegion): array
    {
        $touristicRegion->load([
            'cities.translations',
            'translations'
        ]);

        return [
            'id' => $touristicRegion->id,
            'code' => $touristicRegion->code,
            'name' => $touristicRegion->translated_name,
            'cities' => $touristicRegion->cities->map(function ($city) {
                return [
                    'id' => $city->id,
                    'code' => $city->code,
                    'name' => $city->translated_name,
                ];
            })
        ];
    }
}