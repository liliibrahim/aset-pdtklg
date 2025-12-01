<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Bahagian;
use App\Models\Unit;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Papar borang daftar
     */
    public function create()
    {
        return view('auth.register', [
            'bahagians' => Bahagian::all(),   // Hantar data bahagian untuk dropdown
        ]);
    }

    /**
     * Simpan data pendaftaran
     */
    public function store(Request $request)
    {
        // Format sebelum validate
        $request->merge([
            'name'  => strtoupper($request->name),
            'email' => strtolower($request->email),
        ]);

        // VALIDATION
        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            // Email mesti @selangor.gov.my
            'email' => [
                'required', 'email', 'max:255', 'unique:users',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@selangor.gov.my')) {
                        $fail('Emel mesti menggunakan domain @selangor.gov.my');
                    }
                },
            ],

            // Phone mesti nombor
            'phone' => ['required', 'regex:/^[0-9]+$/', 'max:20'],

            'bahagian_id' => ['required', 'exists:bahagians,id'],
            'unit_id'     => ['required', 'exists:units,id'],

            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // CREATE USER (sekali sahaja)
        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'bahagian_id' => $request->bahagian_id,
            'unit_id'     => $request->unit_id,
            'role'        => 'user',     // default pengguna biasa
            'password'    => Hash::make($request->password),
        ]);

        // Fire event
        event(new Registered($user));

        // Auto login selepas daftar
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
