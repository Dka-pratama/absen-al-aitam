<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\TahunAjar;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class SiswaCrud extends Controller
{
    public function index()
    {
        $Header = 'Data Siswa';

        $siswa = Siswa::with([
            'user',
            'kelasSiswa' => function ($q) {
                $q->whereHas('tahunAjar', function ($q2) {
                    $q2->where('status', 'aktif');
                })->with('kelas');
            },
        ])
            ->whereHas('kelasSiswa.tahunAjar', function ($q) {
                $q->where('status', 'aktif');
            })
            ->paginate(15);

        return view('admin.siswa.index', compact('siswa', 'Header'));
    }

    public function search(Request $r)
    {
        $keyword = $r->search;

        $data = Siswa::with([
            'user',
            'kelasSiswa' => function ($q) {
                $q->whereHas('tahunAjar', fn($q2) => $q2->where('status', 'aktif'))->with('kelas');
            },
        ])
            // ⬇️ WAJIB: filter tahun ajar aktif
            ->whereHas('kelasSiswa.tahunAjar', function ($q) {
                $q->where('status', 'aktif');
            })
            // ⬇️ SEMUA SEARCH DIKELOMPOKKAN
            ->where(function ($q) use ($keyword) {
                $q->where('NISN', 'like', "%$keyword%")
                    ->orWhereHas('user', function ($q2) use ($keyword) {
                        $q2->where('username', 'like', "%$keyword%")->orWhere('name', 'like', "%$keyword%");
                    })
                    ->orWhereHas('kelasSiswa.kelas', function ($q3) use ($keyword) {
                        $q3->where('nama_kelas', 'like', "%$keyword%");
                    });
            })
            ->get();

        return response()->json(
            $data->map(function ($s) {
                return [
                    'id' => $s->id,
                    'NISN' => $s->NISN,
                    'user' => [
                        'username' => $s->user->username ?? '-',
                        'name' => $s->user->name ?? '-',
                    ],
                    'kelas' => [
                        'nama_kelas' => optional($s->kelasSiswa->first()?->kelas)->nama_kelas ?? '-',
                    ],
                    'url_edit' => route('akun-siswa.edit', $s->id),
                    'url_delete' => route('akun-siswa.destroy', $s->id),
                    'url_show' => route('akun-siswa.show', $s->id),
                ];
            }),
        );
    }

    public function show($id)
    {
        $Header = 'Data Siswa';

        $siswa = Siswa::with(['user', 'absensi'])->findOrFail($id);

        // Ambil Tahun Ajar aktif
        $tahunAjarAktif = TahunAjar::where('status', 'aktif')->first();

        // Ambil kelas siswa pada tahun ajar aktif
        $kelasAktif = $siswa->kelas()->wherePivot('tahun_ajar_id', $tahunAjarAktif->id)->first();

        // Hitung absensi
        $hadir = $siswa->absensi->where('status', 'hadir')->count();
        $sakit = $siswa->absensi->where('status', 'sakit')->count();
        $izin = $siswa->absensi->where('status', 'izin')->count();
        $alpa = $siswa->absensi->where('status', 'alpa')->count();

        return view('admin.siswa.show', compact('siswa', 'Header', 'hadir', 'sakit', 'izin', 'alpa', 'kelasAktif'));
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Hapus akun user yang terhubung
        if ($siswa->user && $siswa->user->role == 'siswa') {
            $siswa->user->delete();
        }

        // Hapus data siswa
        $siswa->delete();

        return redirect()->route('akun-siswa.index')->with('success', 'Data siswa & akun user berhasil dihapus.');
    }

    public function create()
    {
        $Header = 'Tambah Akun Siswa';
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas', 'Header'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required|unique:users',
                'password' => 'required',
                'NISN' => 'required|unique:siswa',
                'kelas_id' => 'required',
            ],
            [
                'name.required' => 'Nama lengkap wajib diisi.',
                'username.required' => 'Username wajib diisi.',
                'username.unique' => 'Username sudah digunakan.',
                'password.required' => 'Password wajib diisi.',
                'NISN.required' => 'NISN wajib diisi.',
                'NISN.unique' => 'NISN sudah terdaftar.',
                'kelas_id.required' => 'Kelas wajib dipilih.',
            ],
        );

        // 1. Buat akun user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        // 2. Masukkan siswa
        $siswa = Siswa::create([
            'NISN' => $request->NISN,
            'user_id' => $user->id,
        ]);

        // 3. Masukkan ke tabel kelas_siswa (relasi siswa ke kelas saat ini)
        KelasSiswa::create([
            'siswa_id' => $siswa->id,
            'kelas_id' => $request->kelas_id,
            'tahun_ajar_id' => TahunAjar::where('status', 'aktif')->first()->id ?? null, // opsional jika ada tahun ajar aktif
        ]);

        return redirect()
            ->route('akun-siswa.index')
            ->with('success', 'Akun Siswa berhasil dibuat & dimasukkan ke kelas.');
    }

    public function edit($id)
    {
        $Header = 'Data Siswa';
        $siswa = Siswa::with(['user', 'kelasSiswa.kelas'])->findOrFail($id);

        $kelasAktif = $siswa->kelasSiswa->last()->kelas->id ?? null;

        $kelasList = Kelas::all();

        return view('admin.siswa.edit', compact('siswa', 'kelasList', 'kelasAktif', 'Header'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = $siswa->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'NISN' => 'required|string|max:20|unique:siswa,NISN,' . $siswa->id,
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        // Update User
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Update NISN
        $siswa->update([
            'NISN' => $request->NISN,
        ]);

        // ================================================
        //       UPDATE KELAS AKTIF DI TABLE PIVOT
        // ================================================

        $tahunAktif = TahunAjar::where('status', 'aktif')->first();

        // Ambil pivot untuk tahun ajar aktif
        $pivot = $siswa->kelasSiswa()->where('tahun_ajar_id', $tahunAktif->id)->first();

        if ($pivot) {
            // Update pivot
            $pivot->update([
                'kelas_id' => $request->kelas_id,
            ]);
        } else {
            // Jika belum ada pivot (kasus tertentu)
            $siswa->kelasSiswa()->create([
                'kelas_id' => $request->kelas_id,
                'tahun_ajar_id' => $tahunAktif->id,
            ]);
        }

        return redirect()->route('akun-siswa.index')->with('success', 'Akun siswa berhasil di update.');
    }
    public function importExport()
    {
        $Header = 'Export / Import Data';
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('admin.siswa.import-export', compact('kelas', 'Header'));
    }
    public function template()
    {
        $data = [['NISN', 'Nama', 'Username', 'Password'], ['1234567890', 'Budi Santoso', 'budi', '123456']];

        return Excel::download(
            new class ($data) implements \Maatwebsite\Excel\Concerns\FromArray {
                public function __construct(public array $data) {}
                public function array(): array
                {
                    return $this->data;
                }
            },
            'template-import-siswa.xlsx',
        );
    }

    public function export(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ]);
        $tahunAjar = TahunAjar::where('status', 'aktif')->firstOrFail();

        $kelas = Kelas::findOrFail($request->kelas_id);

        $siswa = Siswa::whereHas('kelasSiswa', function ($q) use ($kelas, $tahunAjar) {
            $q->where('kelas_id', $kelas->id)->where('tahun_ajar_id', $tahunAjar->id);
        })
            ->with('user')
            ->get();

        $data = [['NISN', 'Nama', 'Username', 'Email']];

        foreach ($siswa as $s) {
            $data[] = [$s->NISN, $s->user->name, $s->user->username, $s->user->email];
        }
        $namaFile = 'akun-siswa-' . $kelas->nama_kelas . '-' . str_replace('/', '-', $tahunAjar->tahun) . '.xlsx';

        return Excel::download(
            new class ($data) implements \Maatwebsite\Excel\Concerns\FromArray {
                public function __construct(public array $data) {}
                public function array(): array
                {
                    return $this->data;
                }
            },
            $namaFile,
        );
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $errors = [];
        $rows = Excel::toArray([], $request->file('file'))[0];

        DB::beginTransaction();

        try {
            $tahunAktif = TahunAjar::where('status', 'aktif')->firstOrFail();
            $kelas = Kelas::findOrFail($request->kelas_id);

            foreach ($rows as $i => $row) {
                if ($i == 0) {
                    continue;
                } // skip header
                $baris = $i + 1;

                $nisn = trim($row[0] ?? '');
                $nama = trim($row[1] ?? '');
                $username = trim($row[2] ?? '') ?: $nisn;
                $password = trim($row[3] ?? '') ?: $nisn;

                if (!$nisn || !$nama) {
                    $errors[] = "Baris $baris: NISN & Nama wajib diisi";
                    continue;
                }

                if (User::where('username', $username)->exists()) {
                    $errors[] = "Baris $baris: Username sudah ada";
                    continue;
                }

                // USERS
                $user = User::create([
                    'name' => $nama,
                    'username' => $username,
                    'password' => Hash::make($password),
                    'role' => 'siswa',
                ]);

                // SISWA
                $siswa = Siswa::create([
                    'NISN' => $nisn,
                    'user_id' => $user->id,
                ]);

                // KELAS_SISWA
                DB::table('kelas_siswa')->insert([
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $kelas->id,
                    'tahun_ajar_id' => $tahunAktif->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if (!empty($errors)) {
                DB::rollBack();
                return back()->with('import_errors', $errors);
            }

            DB::commit();
            return back()->with('success', 'Import siswa berhasil');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function exportUpdate(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $tahunAktif = TahunAjar::where('status', 'aktif')->firstOrFail();
        $kelas = Kelas::findOrFail($request->kelas_id);

        $siswa = Siswa::whereHas('kelasSiswa', function ($q) use ($kelas, $tahunAktif) {
            $q->where('kelas_id', $kelas->id)->where('tahun_ajar_id', $tahunAktif->id);
        })
            ->with('user')
            ->get();

        $data = [['siswa_id', 'user_id', 'NISN', 'Nama', 'Username', 'Password']];

        foreach ($siswa as $s) {
            $data[] = [
                $s->id,
                $s->user->id,
                $s->NISN,
                $s->user->name,
                $s->user->username,
                '', // password kosong (opsional)
            ];
        }

        $filename = 'update-siswa-' . str_replace(['/', '\\'], '-', $kelas->nama_kelas) . '.xlsx';

        return Excel::download(
            new class ($data) implements \Maatwebsite\Excel\Concerns\FromArray {
                public function __construct(public array $data) {}
                public function array(): array
                {
                    return $this->data;
                }
            },
            $filename,
        );
    }
    public function importUpdate(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $rows = Excel::toArray([], $request->file('file'))[0];
        $errors = [];

        DB::beginTransaction();

        try {
            foreach ($rows as $i => $row) {
                if ($i === 0) {
                    continue;
                } // skip header
                $baris = $i + 1;

                $siswaId = $row[0] ?? null;
                $userId = $row[1] ?? null;
                $nisn = trim($row[2] ?? '');
                $nama = trim($row[3] ?? '');
                $username = trim($row[4] ?? '');
                $password = trim($row[5] ?? '');

                if (!$siswaId || !$userId) {
                    $errors[] = "Baris $baris: ID tidak valid";
                    continue;
                }

                $siswa = Siswa::find($siswaId);
                $user = User::find($userId);

                if (!$siswa || !$user) {
                    $errors[] = "Baris $baris: Data siswa/user tidak ditemukan";
                    continue;
                }

                // Cegah username duplikat
                if (User::where('username', $username)->where('id', '!=', $user->id)->exists()) {
                    $errors[] = "Baris $baris: Username sudah digunakan";
                    continue;
                }

                // UPDATE USER
                $user->update([
                    'name' => $nama,
                    'username' => $username,
                ]);

                // UPDATE PASSWORD (jika diisi)
                if (!empty($password)) {
                    $user->update([
                        'password' => Hash::make($password),
                    ]);
                }

                // UPDATE SISWA
                $siswa->update([
                    'NISN' => $nisn,
                ]);
            }

            if (!empty($errors)) {
                DB::rollBack();
                return back()->with('import_errors', $errors);
            }

            DB::commit();
            return back()->with('success', 'Update data siswa berhasil');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
