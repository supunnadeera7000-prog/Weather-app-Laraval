<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->query('city');
        $latitude = $request->query('latitude');
        $longitude = $request->query('longitude');

        $weather = null;
        $error = null;
        $country = '';

        try {
            // Search by city name
            if (!empty($city)) {
                $locationResponse = Http::get(
                    'https://geocoding-api.open-meteo.com/v1/search',
                    [
                        'name' => $city,
                        'count' => 1,
                        'language' => 'en',
                        'format' => 'json',
                    ]
                );

                if (!$locationResponse->successful()) {
                    $error = 'Unable to find the city. Please try again.';
                } else {
                    $locations = $locationResponse->json('results', []);

                    if (empty($locations)) {
                        $error = 'City not found. Please try another city.';
                    } else {
                        $location = $locations[0];

                        $latitude = $location['latitude'];
                        $longitude = $location['longitude'];
                        $city = $location['name'];
                        $country = $location['country'] ?? '';
                    }
                }
            }

            // No city or coordinates: wait for browser location
            if (
                empty($city) &&
                ($latitude === null || $longitude === null)
            ) {
                return view('welcome', [
                    'city' => null,
                    'weather' => null,
                    'error' => null,
                ]);
            }

            // Get weather using city coordinates or browser coordinates
            if ($error === null) {
                $weatherResponse = Http::get(
                    'https://api.open-meteo.com/v1/forecast',
                    [
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,weather_code,wind_speed_10m',
                        'timezone' => 'auto',
                    ]
                );

                if ($weatherResponse->successful()) {
                    $weather = $weatherResponse->json('current');

                    if (is_array($weather)) {
                        if (empty($city)) {
                            $city = 'Your Location';
                        }

                        $weather['city'] = $city;
                        $weather['country'] = $country;
                    } else {
                        $error = 'Weather data unavailable. Please try again.';
                    }
                } else {
                    $error = 'Weather data unavailable. Please try again.';
                }
            }
        } catch (\Throwable $e) {
            $error = 'Unable to connect. Please check your internet connection.';
        }

        return view('welcome', [
            'city' => $city,
            'weather' => $weather,
            'error' => $error,
        ]);
    }
}