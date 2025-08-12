<?php

namespace App\Services\Utils;

use Illuminate\Support\Facades\Http;

class GoogleGeocodingService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.google_maps.api_key');
    }

    /**
     * Geocode an address using Google Maps Geocoding API.
     *  
     * @param string $address
     * @return array|null Returns the geocoded data or null if not found.
     **/
    public function geocode(string $address): ?array
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $address,
            'key' => $this->apiKey,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if ($data['status'] === 'OK' && !empty($data['results'])) {
                return $data['results'][0]; // Devuelve el primer resultado
            }
        }

        return null;
    }

    public function getCoordinates(string $address): ?array
    {
        $result = $this->geocode($address);

        if ($result && isset($result['geometry']['location'])) {
            return [
                'lat' => $result['geometry']['location']['lat'],
                'lng' => $result['geometry']['location']['lng'],
            ];
        }

        return null;
    }

    // address with route and street number ONLY
    public function getFormattedAddress(string $address): ?string
    {
        $result = $this->geocode($address);

        if ($result && isset($result['formatted_address'])) {
            return $result['formatted_address'];
        }

        return null;
    }
}
