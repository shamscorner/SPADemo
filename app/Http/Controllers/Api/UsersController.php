<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
    * Author: shamscorner
    * DateTime: 30/September/2019 - 14:19:35
    *
    * show the users information with pagination with 10 users
    *
    */
    public function index()
    {
        return UserResource::collection(User::latest()->paginate(10));
    }

    /**
    * Author: shamscorner
    * DateTime: 30/September/2019 - 15:35:46
    *
    * show user's information
    *
    */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
    * Author: shamscorner
    * DateTime: 30/September/2019 - 16:22:12
    *
    * update the user data
    *
    */
    public function update(User $user, Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user->update($data);

        return new UserResource($user);
    }

    /**
    * Author: shamscorner
    * DateTime: 30/September/2019 - 16:44:36
    *
    * delete the user
    *
    */
    public function destroy(User $user)
    {
        $user->delete();

        return response(null, 204);
    }

    /**
    * Author: shamscorner
    * DateTime: 30/September/2019 - 17:46:21
    *
    * create a user
    *
    */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:8'
        ]);

        return new UserResource(User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]));
    }
}
