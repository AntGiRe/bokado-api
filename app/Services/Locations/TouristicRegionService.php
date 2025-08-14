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
        $query = TouristicRegion::query();

        // Filtrar por ID o nombre de zona turística
        if (!empty($filters['touristic_region'])) {
            $query->where(function ($q) use ($filters) {
                // Buscar por ID si es numérico
                if (is_numeric($filters['touristic_region'])) {
                    $q->where('id', $filters['touristic_region']);
                }
                // Buscar por nombre
                $q->orWhere('name', 'like', '%' . $filters['touristic_region'] . '%');
            });
        }

        return $query->select(['id', 'name', 'description'])
            ->orderBy('name')
            ->paginate(50)
            ->through(function (TouristicRegion $touristicRegion) {
                return [
                    'id' => $touristicRegion->id,
                    'name' => $touristicRegion->name,
                    'description' => $touristicRegion->description,
                ];
            });
    }

    /**
     * Get touristic region with all related data.
     */
    public function getTouristicRegionWithRelations(TouristicRegion $touristicRegion): array
    {
        $touristicRegion->load([
            'cities.translations'
        ]);

        return [
            'id' => $touristicRegion->id,
            'name' => $touristicRegion->name,
            'description' => $touristicRegion->description,
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