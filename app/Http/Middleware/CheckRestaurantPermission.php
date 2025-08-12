<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Restaurant;

class CheckRestaurantPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $restaurant = $request->route('restaurant');

        if (!$restaurant instanceof Restaurant) {
            $restaurant = Restaurant::find($restaurant);

            if (!$restaurant) {
                return response()->json(['message' => 'Restaurant not found'], 404);
            }
        }

        // Check if the user has a valid relationship with the restaurant
        $relation = $user->restaurants()
            ->where('restaurants.id', $restaurant->id)
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->whereIn('role', ['owner', 'admin'])
            ->first();

        if (!$relation) {
            return response()->json(['message' => 'You do not have sufficient permissions to access this restaurant'], 403);
        }

        return $next($request);
    }
}
