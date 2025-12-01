<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wali;
use App\Models\User;

class WaliCrud extends Controller
{
    public function index()
    {
        $walikelas = Wali::with('user')->get();
        return view('admin.wali.index', compact('walikelas'));
    }

    public function show($id)
    {
        $wali = Wali::with('user')->findOrFail($id);
        return view('crud.wali.show', compact('wali'));
    }

    public function destroy($id)
    {
        $wali = Wali::findOrFail($id);
        $wali->delete();
        return redirect()->route('wali.index')->with('success', 'Akun Wali Kelas berhasil dihapus.');
    }

    public function create()
    {
        return view('admin.wali.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'NIP' => 'required|string|unique:wali',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'wali',
        ]);

        Wali::create([
            'user_id' => $user->id,
        ]);

        return redirect()->route('wali.index')->with('success', 'Akun Wali Kelas berhasil dibuat.');
    }

    public function edit($id)
    {
        $wali = Wali::with('user')->findOrFail($id);
        return view('admin.wali.edit', compact('wali'));
    }

    public function update(Request $request, $id)
    {
        $wali = Wali::findOrFail($id);
        $user = User::findOrFail($wali->user_id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'NUPTK' => 'required|string|unique:wali' . $wali->id,
        ]);

        $user->update([
            'nama' => $request->nama,
            'username' => $request->username,
        ]);

        if ($request->password) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        $wali->update([
            'NUPTK' => $request->NUPTK,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('wali.index')->with('success', 'Akun Wali Kelas berhasil diperbarui.');
    }
}
