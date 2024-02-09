<?php

namespace App\Http\Controllers\V1\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits_between:5,11'
        ]);

        $user->update($request->only(['name', 'email', 'phone']));

        $user = new UserResource($user);

        return $this->sendResponse($user, "Success!");
    }

    public function upload(Request $request, User $user)
    {
        dd($request->all());
    }
}
