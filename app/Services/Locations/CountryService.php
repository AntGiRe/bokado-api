<?php
namespace App\Services\Locations;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Country;
use Illuminate\Support\Collection;

class CountryService
{
    public function getAll(?string $nameFilter = null): Collection
    {
        $locale = app()->getLocale();

        $query = Country::with('translations');

        if ($nameFilter) {
            $query->where(function ($q) use ($locale, $nameFilter) {
                // Buscar por ID si es numérico
                if (is_numeric($nameFilter)) {
                    $q->where('id', $nameFilter);
                }
                // Buscar por código
                $q->orWhere('code', 'like', "%{$nameFilter}%")
                  // Buscar por nombre traducido
                  ->orWhereHas('translations', function ($tq) use ($locale, $nameFilter) {
                      $tq->where('locale', $locale)
                         ->where('name', 'like', "%{$nameFilter}%");
                  });
            });
        }

        return $query->get()->map(function (Country $country) {
            return [
                'id' => $country->id,
                'code' => $country->code,
                'name' => $country->translated_name,
            ];
        });
    }
}