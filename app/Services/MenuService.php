<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class MenuService
{
    public function store(array $params = [])
    {
        try {
            $menu = Menu::create([
                'name' => $params['name'],
                'price' => $params['price'],
                'desc' => $params['desc'] ?? null,
                'priority' => $params['priority'] ?? 1,
                'category_id' => $params['category'] ?? null,
                'restaurant_id' => $params['restaurant'] ?? null,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return $menu;
        } catch (\Exception $e) {
            return [
                "message" => $e->getMessage()
            ];
        }
    }

    public function update(array $params = [], $id)
    {
        try {
            $menu = Menu::findOrFail($id);
            $menu->update([
                'name' => $params['name'],
                'price' => $params['price'],
                'desc' => $params['desc'] ?? null,
                'priority' => $params['priority'] ?? 1,
                'category_id' => $params['category'] ?? null,
                'restaurant_id' => $params['restaurant'] ?? null,
                'updated_by' => Auth::id(),
            ]);

            return $menu;
        } catch (\Exception $e) {
            return [
                "message" => $e->getMessage()
            ];
        }
    }
}
