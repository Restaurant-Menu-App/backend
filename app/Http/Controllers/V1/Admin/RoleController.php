<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function getRoles()
    {
        $roles = Role::notAdmin()->notDeveloper()->filterOn()->latest()->get();

        return response()->json([
            'roles' => $roles
        ]);
    }
}
