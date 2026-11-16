<?php

namespace App\Http\Controllers;

use App\Models\MasterRuang;
use Illuminate\Http\Request;

class MasterRuangController extends Controller
{
    /**
     * Menampilkan daftar seluruh master ruang ujian/sidang (Read).
     * Mendukung inline edit jika terdapat query parameter ?edit={id}
     * atau mode tambah jika ?mode=tambah sesuai tampilan asli masterruang.php
     */
    public function index(Request $request)
    {
        $data_ruang = MasterRuang::orderBy('id', 'asc')->get();
        $data_edit = null;

        if ($request->has('edit')) {
            $data_edit = MasterRuang::find($request->query('edit'));
        }

        return view('masterruang', compact('data_ruang', 'data_edit'));
    }

    /**
     * Menampilkan halaman formulir Tambah Ruang (View 2).
     */
    public function create()
    {
        return view('tambahruang');
    }

    /**
     * Menyimpan data ruang baru ke dalam database (Create).
     */
    public function store(Request $request)
    {
        // Mendukung nama field 'nama_ruang' maupun 'N.Ruang' / 'N_Ruang' dari formulir Minggu 2
        $nama_ruang = $request->input('nama_ruang') ?? $request->input('N_Ruang') ?? $request->input('N.Ruang');
        $gedung = $request->input('gedung') ?? $request->input('GD');

        $request->merge([
            'nama_ruang' => $nama_ruang,
            'gedung' => $gedung,
        ]);

        $validated = $request->validate([
            'nama_ruang' => 'required|string|max:100',
            'gedung'     => 'required|string|max:100',
        ], [
            'nama_ruang.required' => 'Nama ruang wajib diisi.',
            'gedung.required'     => 'Nama/Nomor gedung wajib diisi.',
        ]);

        MasterRuang::create($validated);

        return redirect()->route('ruang.index')->with('success', 'Data ruang sidang berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir edit ruang sidang.
     */
    public function edit($id)
    {
        $data_edit = MasterRuang::findOrFail($id);
        return view('editruang', compact('data_edit'));
    }

    /**
     * Memperbarui data ruang sidang di database (Update).
     */
    public function update(Request $request, $id)
    {
        $ruang = MasterRuang::findOrFail($id);

        $nama_ruang = $request->input('nama_ruang') ?? $request->input('N_Ruang') ?? $request->input('N.Ruang');
        $gedung = $request->input('gedung') ?? $request->input('GD');

        $request->merge([
            'nama_ruang' => $nama_ruang,
            'gedung' => $gedung,
        ]);

        $validated = $request->validate([
            'nama_ruang' => 'required|string|max:100',
            'gedung'     => 'required|string|max:100',
        ], [
            'nama_ruang.required' => 'Nama ruang wajib diisi.',
            'gedung.required'     => 'Nama/Nomor gedung wajib diisi.',
        ]);

        $ruang->update($validated);

        return redirect()->route('ruang.index')->with('success', 'Data ruang sidang berhasil diperbarui!');
    }

    /**
     * Menghapus data ruang sidang dari database (Delete).
     */
    public function destroy($id)
    {
        $ruang = MasterRuang::findOrFail($id);
        $ruang->delete();

        return redirect()->route('ruang.index')->with('success', 'Data ruang sidang berhasil dihapus!');
    }

    /**
     * Menampilkan halaman menu portal Ruang dan Fasilitas Sidang (Minggu 2 HTML).
     */
    public function dashboard()
    {
        return view('ruang_dan_fasilitas');
    }
}
