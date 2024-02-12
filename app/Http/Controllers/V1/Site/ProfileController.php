<?php

namespace App\Http\Controllers\V1\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $mediaSvc;

    public function __construct(MediaService $mediaSvc)
    {
        $this->mediaSvc = $mediaSvc;
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits_between:5,11'
        ]);

        $user->update($request->only(['name', 'email', 'phone']));

        $user = new UserResource($user);

        return $this->sendResponse($user, "Success!");
    }

    public function upload(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $mediaFormdata = [
            'media' => $request->file('image'),
            'type' => 'profile',
        ];

        if (public_path($user->profile)) {
            File::delete(public_path($user->profile));
        }

        $url = $this->mediaSvc->storeMedia($mediaFormdata);

        $user->update([
            'profile' => $url
        ]);

        return $this->sendResponse(new UserResource($user), "Success!");
    }

    public function changePassword(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'new_confirm_password' => 'required_with:new_password|same:new_password|min:8',
        ]);

        $hashedPassword = $user->password;
        if (!Hash::check($request->current_password, $hashedPassword)) {
            return $this->sendError('Current Password Do Not Match.', 422);
        } else {
            $user->password = Hash::make($request->new_password);
            $user->update();

            // login again
            // Auth::user()->currentAccessToken()->delete();
            return $this->sendResponse([], "Password Changed Successfull.");
        }
    }
}
