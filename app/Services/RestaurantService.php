<?php

namespace App\Services;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RestaurantService
{
    public function store(array $params = [])
    {
        try {

            if ($params['image']) {
                $file = $params['image'];
                $fileNameWithExt = $file->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $fileNameToStore = $fileName . '_' . time() . '.' . $file->extension();

                $url = $file->storeAs('public', $fileNameToStore);

                $fileName = $fileName . '.' . $file->extension();

                Storage::move($url, 'public/restaurants/' . $fileNameToStore); //tmp

                $url = Storage::url('public/restaurants/' . $fileNameToStore);
            }

            $restaurant = Restaurant::create([
                "slug" => Str::slug($params['name']),
                "name" => $params['name'],
                "phone" => $params['phone'],
                "email" => $params['email'] ?? null,
                "website_url" => $params['website_url'] ?? null,
                "facebook_url" => $params['facebook_url'] ?? null,
                "address" => $params['address'] ?? null,
                "desc" => $params['desc'] ?? null,
                "open_time" => $params['open_time'] ?? null,
                "close_time" => $params['close_time'] ?? null,
                "close_on" => $params['close_on'] ?? null,
                "user_id" => Auth::id(),
                "image" => $url ?? null
            ]);

            $restaurant->categories()->sync($params['categories']);

            return $restaurant;
        } catch (\Exception $e) {
            return [
                "message" => $e->getMessage()
            ];
        }
    }

    public function update(array $params = [], $id)
    {
        try {
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->slug = Str::slug($params['name']);
            $restaurant->name = $params['name'];
            $restaurant->phone = $params['phone'];
            $restaurant->email = $params['email'] ?? null;
            $restaurant->website_url = $params['website_url'] ?? null;
            $restaurant->facebook_url = $params['facebook_url'] ?? null;
            $restaurant->address = $params['address'] ?? null;
            $restaurant->desc = $params['desc'] ?? null;
            $restaurant->open_time = $params['open_time'] ?? null;
            $restaurant->close_time = $params['close_time'] ?? null;
            $restaurant->close_on = $params['close_on'] ?? null;
            $restaurant->update();

            $restaurant->categories()->sync($params['categories']);

            return $restaurant;
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
            ];
        }
    }
}
