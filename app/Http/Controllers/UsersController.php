<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = User::query();

    // Cek apakah ada input pencarian
    if ($request->has('table_search') && $request->table_search) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->table_search . '%')
              ->orWhere('email', 'like', '%' . $request->table_search . '%');
        });
    }

    // Cek role user yang login
    if (auth()->user()->hasRole('admin')) {
        // Admin bisa lihat semua user
        $users = $query->get();
    } else {
        // Selain admin hanya bisa lihat dirinya sendiri
        $users = $query->where('id', auth()->id())->get();
    }

    return view('users.index', compact('users'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   // STORE
public function store(Request $request)
{
    $validatedData = $request->validate([
        'name'     => 'required|string|max:255',
        'nik'      => 'required|digits:16|unique:users,nik',
        'email'    => 'required|email|unique:users,email',
        'phone'    => 'required|string|max:15',
        'password' => 'required|string|min:8|confirmed',
        'role'     => 'required|string',
        'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user = User::create([
        'name'     => $validatedData['name'],
        'nik'      => $validatedData['nik'],
        'email'    => $validatedData['email'],
        'phone'    => $validatedData['phone'],
        'password' => Hash::make($validatedData['password']),
    ]);

    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('photos', 'public');
        $user->photo = $photoPath;
    }

    $user->save();
    $user->assignRole($validatedData['role']);

    return redirect()->route('admin.UsersIndex')->with('success', 'Pengguna berhasil ditambahkan.');
}

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   // UPDATE
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validatedData = $request->validate([
        'name'  => 'required|string|max:255',
        'nik'   => 'required|digits:16|unique:users,nik,' . $id,
        'email' => 'required|email|unique:users,email,' . $id,
        'phone' => 'required|string|max:15',
        'role'  => 'required|string',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('photo')) {
        if ($user->photo && \Storage::disk('public')->exists($user->photo)) {
            \Storage::disk('public')->delete($user->photo);
        }

        $photoPath = $request->file('photo')->store('photos', 'public');
        $validatedData['photo'] = $photoPath;
    }

    $user->update($validatedData);

    $user->roles->isNotEmpty()
        ? $user->syncRoles([$validatedData['role']])
        : $user->assignRole($validatedData['role']);

    return redirect()->route('admin.UsersIndex')->with('success', 'Pengguna berhasil diperbarui.');
}



public function destroy(string $id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.UsersIndex')->with('success', 'User berhasil dihapus.');
}

}
