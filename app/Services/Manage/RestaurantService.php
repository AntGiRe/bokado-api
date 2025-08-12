<?php

namespace App\Services\Manage;

use App\Models\Restaurant;
use App\Services\Utils\GoogleGeocodingService;
use App\Models\User;

class RestaurantService
{
    protected GoogleGeocodingService $geocodingService;

    public function __construct(GoogleGeocodingService $geocodingService)
    {
        $this->geocodingService = $geocodingService;
    }

    public function setSlug(Restaurant $restaurant): void
    {
        $restaurant->slug = $restaurant->generateSlug($restaurant->name, $restaurant->id);

        $restaurant->save();
    }

    public function setLocationData(Restaurant $restaurant): void
    {
        // Geocoding
        $fullAddress = $restaurant->getFullAddress();
        $geocode = $this->geocodingService->geocode($fullAddress);

        if ($geocode && isset($geocode['geometry']['location'])) {
            $restaurant->latitude = $geocode['geometry']['location']['lat'];
            $restaurant->longitude = $geocode['geometry']['location']['lng'];
        }

        if ($geocode && isset($geocode['address_components'])) {
            $addressComponents = collect($geocode['address_components']);

            $route = $addressComponents->first(fn($c) => in_array('route', $c['types']));
            $streetNumber = $addressComponents->first(fn($c) => in_array('street_number', $c['types']));
            $postalCode = $addressComponents->first(fn($c) => in_array('postal_code', $c['types']));

            if ($route && $streetNumber) {
                $restaurant->address = "{$route['long_name']}, {$streetNumber['long_name']}";
            } else {
                $restaurant->address = $fullAddress;
            }

            if ($postalCode) {
                $restaurant->postal_code = $postalCode['long_name'];
            }
        }

        $restaurant->save();

        $restaurant->refresh();
    }

    public function createWithOwner(array $validatedData, User $owner): Restaurant
    {
        $restaurant = Restaurant::create($validatedData);

        // Set slug
        $this->setSlug($restaurant);

        // Set location data
        $this->setLocationData($restaurant);

        // Asociar con el owner
        $restaurant->users()->attach($owner->id, [
            'role' => 'owner',
            'start_date' => now()
        ]);

        $restaurant->load('currency');

        return $restaurant;
    }

    public function update(Restaurant $restaurant, array $data): Restaurant
    {
        $restaurant->update($data);

        if (array_key_exists('name', $data)) {
            $this->setSlug($restaurant);
        }

        if (
            array_key_exists('address', $data)
            || array_key_exists('postal_code', $data)
            || array_key_exists('city_id', $data)
        ) {
            $this->setLocationData($restaurant);
        }

        return $restaurant;
    }
}
