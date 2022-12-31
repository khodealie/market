<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserRes;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{

    private function getCustomerRole(): Role
    {
        return Role::where('name', config('setup.ROLES.CUSTOMER.NAME'))->first();
    }

    private function getSellerRole()
    {
        return Role::where('name', config('setup.ROLES.SELLER.NAME'))->first();
    }

    public function registerOrLogin(Request $request): UserRes
    {
        $request->validate([
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/']
        ]);
        $user = User::where('email', $request['email'])->first();
        if (empty($user)) {
            $user = new User();
            $user['email'] = $request['email'];
            $user['password'] = Hash::make($request['password']);
            $user->role()->associate($this->getCustomerRole());
            $user->save();
        }
        if (!(Hash::check($request['password'], $user['password']))) {
            abort(401, 'wrong password.');
        }
        $user->access_token = $user->createToken('')->plainTextToken;
        return new UserRes($user);
    }

    public function promoteCustomer2Seller(User $user): JsonResponse
    {
        $user->role()->associate($this->getSellerRole());
        $user->save();
        return Response::json(['message' => 'User has been successfully promoted to seller role']);
    }
}
