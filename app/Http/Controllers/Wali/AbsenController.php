<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absen;
use App\Models\Siswa;
use App\Models\Wali;
use App\Models\Kelas;

class AbsenController extends Controller
{
    public function index()
    {
        //mengambil data wali kelas yang sedang login
        $user = auth()->user();

        //mengambil data wali berdasarkan user_id
        $wali = $user->wali;

        //mengambil data siswa berdasarkan kelas_id wali kelas
        $siswa = Siswa::where('kelas_id', $wali->kelas_id)->with('user')->get();
        return view('wali.absen.siswa', compact('siswa', 'wali'));
    }
}
