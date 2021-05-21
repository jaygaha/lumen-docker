<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function getProfile()
    {
        return response()->json(['user' => Auth::user()], 200);
    }

    /**
     * destroy current JWT token
     *
     * @return void
     */
    public function logout()
    {
        auth()->logout(true);
        return response()->json('Logout successfully.', 200);
    }
}