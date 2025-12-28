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
        // Normalisasi data input
        $request->merge([
            'name'  => strtoupper($request->name),
            'email' => strtolower($request->email),
        ]);

        // Validasi maklumat pendaftaran
        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            // Emel rasmi sahaja dibenarkan
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

        // Tetapkan role pengguna
        $role = 'user'; // default: user daftar sendiri

        if (Auth::check() && Auth::user()->role === 'admin') {
            $role = $request->role ?? 'user';
        }

        // Cipta rekod pengguna baharu
        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'bahagian_id' => $request->bahagian_id,
            'unit_id'     => $request->unit_id,
            'role'        => $role,
            'password'    => Hash::make($request->password),
        ]);

        // Trigger event pendaftaran pengguna
        event(new Registered($user));
          
        // Redirect ke dashboard selepas pendaftaran berjaya
        return redirect()->route('dashboard')
            ->with('success', 'Pendaftaran berjaya. Selamat datang!');
            }
        }
