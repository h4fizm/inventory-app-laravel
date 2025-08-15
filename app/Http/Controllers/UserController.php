<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Tampilkan halaman manage user dengan data dari database.
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('menu.data-user', compact('users', 'roles'));
    }

    /**
     * Tampilkan form untuk membuat user baru.
     */
    public function create()
    {
        $roles = Role::all();
        return view('menu.tambah-user', compact('roles'));
    }

    /**
     * Simpan user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole($request->role);
            DB::commit();

            return redirect()->route('data-user.index')->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $data_user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($data_user->id)],
            'role' => 'required|string|exists:roles,name',
        ]);

        try {
            DB::beginTransaction();
            $data_user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            $data_user->syncRoles($request->role);
            DB::commit();

            return redirect()->route('data-user.index')->with('success', 'Data user berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function destroy(User $data_user)
    {
        try {
            $data_user->delete();
            return redirect()->route('data-user.index')->with('success', 'Data user berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

}