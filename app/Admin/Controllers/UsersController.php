<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UsersController extends Controller
{
    public function getUsers(): AnonymousResourceCollection
    {
        return UserResource::collection(
            User::query()
                ->paginate(20)
        );
    }
}
