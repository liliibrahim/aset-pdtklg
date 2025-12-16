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
            'bahagians' => Bahagian::all(),
        ]);
    }

    /**
     * Simpan data pendaftaran
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | NORMALISASI DATA
        |--------------------------------------------------------------------------
        */
        $request->merge([
            'name'  => strtoupper($request->name),
            'email' => strtolower($request->email),
        ]);

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */
        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            // Emel rasmi sahaja
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@selangor.gov.my')) {
                        $fail('Emel mesti menggunakan domain @selangor.gov.my');
                    }
                },
            ],

            'phone' => ['required', 'regex:/^[0-9]+$/', 'max:20'],

            'bahagian_id' => ['required', 'exists:bahagians,id'],
            'unit_id'     => ['required', 'exists:units,id'],

            'password' => ['required', 'confirmed', 'min:8'],

            // Role hanya divalidasi jika admin yang daftar
            'role' => ['nullable', 'in:admin,ict,user'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | TENTUKAN ROLE (KAWALAN UTAMA)
        |--------------------------------------------------------------------------
        */
        $role = 'user'; // default: user daftar sendiri

        if (Auth::check() && Auth::user()->role === 'admin') {
            $role = $request->role ?? 'user';
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE USER
        |--------------------------------------------------------------------------
        */
        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'bahagian_id' => $request->bahagian_id,
            'unit_id'     => $request->unit_id,
            'role'        => $role,
            'password'    => Hash::make($request->password),
        ]);

        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        */
        event(new Registered($user));

        /*
        |--------------------------------------------------------------------------
        | LOGIN LOGIC
        |--------------------------------------------------------------------------
        | - User daftar sendiri → auto login
        | - Admin daftar user → TIDAK auto login
        |--------------------------------------------------------------------------
        */
        if (!Auth::check()) {
            Auth::login($user);
           return redirect()
    ->route('admin.register')
    ->with('success', 'Pengguna berjaya ditambah. Sila tambah pengguna lain.');
        }

        // Admin daftar pengguna → kembali ke senarai pengguna
        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berjaya didaftarkan.');
    }
}
