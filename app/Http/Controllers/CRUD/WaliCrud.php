<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WaliKelas as Wali;
use App\Models\User;
use App\Models\Kelas;
use App\Models\TahunAjar;
use Illuminate\View\View;

class WaliCrud extends Controller
{
    public function index(): View
    {
        $Header = 'Data Wali Kelas';
        $walikelas = Wali::with(['user', 'kelas'])->paginate(15);
        return view('admin.wali.index', compact('walikelas', 'Header'));
    }

    public function search(Request $r)
    {
        $keyword = $r->search;

        $data = Wali::with(['user', 'kelas'])
            ->whereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")->orWhere('username', 'like', "%$keyword%");
            })
            ->orWhere('NUPTK', 'like', "%$keyword%")
            ->get();

        return response()->json(
            $data->map(function ($w) {
                return [
                    'id' => $w->id,
                    'NUPTK' => $w->NUPTK,
                    'user' => [
                        'name' => $w->user->name,
                    ],
                    'kelas' => [
                        'nama_kelas' => $w->kelas->nama_kelas ?? '-',
                    ],

                    // URL dikirim sebagai string aman
                    'url_edit' => route('akun-walikelas.edit', $w->id),
                    'url_delete' => route('akun-walikelas.destroy', $w->id),
                    'url_show' => route('akun-walikelas.show', $w->id),
                ];
            }),
        );
    }

    public function show($id)
    {
        $Header = 'Data Wali Kelas';
        $wali = Wali::with('user')->findOrFail($id);
        return view('admin.wali.show', compact('wali', 'Header'));
    }

    public function destroy($id)
    {
        $wali = Wali::findOrFail($id);

        // hapus user terkait
        if ($wali->user) {
            $wali->user->delete();
        }

        // hapus data wali_kelas
        $wali->delete();

        return redirect()->route('akun-walikelas.index')->with('success', 'Akun Wali Kelas dan User berhasil dihapus.');
    }

    public function create()
    {
        $tahunAjar = TahunAjar::all();
        $kelas = Kelas::all();
        $Header = 'Data Wali Kelas';
        return view('admin.wali.create', compact('tahunAjar', 'Header', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'NUPTK' => 'required|string|unique:wali_kelas,NUPTK',
                'username' => 'required|string|max:255|unique:users,username',
                'password' => 'required|string|min:6',
            ],
            [
                'name.required' => 'Nama Harus diisi.',
                'NUPTK.unique' => 'NUPTK sudah digunakan.',
                'username.unique' => 'Username sudah digunakan.',
            ],
        );

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'wali',
        ]);

        Wali::create([
            'NUPTK' => $request->NUPTK,
            'kelas_id' => $request->kelas_id,
            'tahun_ajar_id' => $request->tahun_ajar_id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('akun-walikelas.index')->with('success', 'Akun Wali Kelas berhasil dibuat.');
    }

    public function edit($id)
    {
        $Header = 'Edit Wali Kelas';
        $wali = Wali::with('user')->findOrFail($id);
        $kelas = Kelas::all();
        return view('admin.wali.edit', compact('wali', 'kelas', 'Header'));
    }

    public function update(Request $request, $id)
    {
        $wali = Wali::findOrFail($id);
        $user = User::findOrFail($wali->user_id);

        $request->validate(
            [
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $user->id,
                'NUPTK' => 'required|string|unique:wali_kelas,NUPTK,' . $wali->id,
            ],
            [
                'name.required' => 'Nama Harus diisi.',
                'username.unique' => 'Username sudah digunakan.',
                'NUPTK.unique' => 'NUPTK sudah digunakan.',
            ],
        );

        $user->update([
            'name' => $request->name,
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

        return redirect()->route('akun-walikelas.index')->with('success', 'Akun Wali Kelas berhasil diperbarui.');
    }
}
