<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    private static string $title;
    private Mahasiswa $mahasiswa;

    public function __construct(Mahasiswa $mahasiswa)
    {
        self::$title = 'Daftar Mahasiswa';
        $this->mahasiswa = $mahasiswa;
    }

    public function index()
    {
        return view('mahasiswa.index', [
            'title' => self::$title,
            'data' => $this->mahasiswa->get(),
        ]);
    }

    public function tambah(Request $request)
    {
        $selectedValue = $request->input('prodi_dropdown');
        if (!$this->mahasiswa->where('nim', $_POST['nim_mahasiswa'])->exists()) {
            $this->mahasiswa->create([
                'nim' => $_POST['nim_mahasiswa'],
                'nama' => $_POST['nama_mahasiswa'],
                'prodi' => $selectedValue,
            ]);
        }
        return redirect('daftarmahasiswa');
    }

    public function hapus($nim)
    {
        $this->mahasiswa->where('nim', $nim)->delete();
        return redirect('daftarmahasiswa');
    }
}
