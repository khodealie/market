<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthUserRes;
use App\Http\Resources\AddressRes;
use App\Models\Address;
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

    public function registerOrLogin(Request $request): AuthUserRes
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
        return new AuthUserRes($user);
    }

    public function promoteCustomer2Seller(User $user): JsonResponse
    {
        $user->role()->associate($this->getSellerRole());
        $user->save();
        return Response::json(['message' => 'User has been successfully promoted to seller role']);
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'longitude' => ['required'],
            'latitude' => ['required']
        ]);
        $address = new Address();
        $address['longitude'] = $request['longitude'];
        $address['latitude'] = $request['latitude'];
        if (!empty($request['address'])) $address['address'] = $request['address'];
        if (!empty($request['workplace']) && is_bool($request['workplace'])) $address['workplace'] = $request['workplace'];
        $address->user()->associate(auth()->user());
        $address->save();
        return new AddressRes($address);
    }
}
