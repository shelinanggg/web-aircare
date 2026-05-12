<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('users.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'min:6',
            ],

            'role' => [
                'required',
                'in:admin,staff',
            ],

            'campus' => [
                'nullable',
                'in:kampus-a,kampus-b,kampus-c',
            ],

        ]);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email,' . $user->id,
            ],

            'password' => [
                'nullable',
                'min:6',
            ],

            'role' => [
                'required',
                'in:admin,staff',
            ],

            'campus' => [
                'nullable',
                'in:kampus-a,kampus-b,kampus-c',
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | PASSWORD OPTIONAL
        |--------------------------------------------------------------------------
        */

        if (empty($validated['password'])) {

            unset($validated['password']);

        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | CEGAH HAPUS AKUN SENDIRI
        |--------------------------------------------------------------------------
        */

        if ($user->id === auth()->id()) {

            return back()->with(
                'error',
                'Tidak dapat menghapus akun sendiri.'
            );
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}