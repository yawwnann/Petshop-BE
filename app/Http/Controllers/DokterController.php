<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDokterRequest;

class DokterController extends Controller
{
    // List dokter dengan search & filter
    public function index(Request $request)
    {
        $query = Dokter::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('no_str', 'like', "%$search%")
                    ->orWhere('spesialisasi', 'like', "%$search%")
                    ->orWhere('telepon', 'like', "%$search%")
                    ->orWhere('alamat', 'like', "%$search%");
            });
        }
        if ($request->filled('spesialisasi')) {
            $query->where('spesialisasi', $request->spesialisasi);
        }
        $dokters = $query->orderBy('nama')->paginate(10);
        $spesialisasiList = Dokter::select('spesialisasi')->distinct()->pluck('spesialisasi');
        return view('dokter.index', compact('dokters', 'spesialisasiList'));
    }

    public function create()
    {
        return view('dokter.create');
    }

    public function store(StoreDokterRequest $request)
    {
        Dokter::create($request->validated());
        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function edit(Dokter $dokter)
    {
        return view('dokter.edit', compact('dokter'));
    }

    public function update(StoreDokterRequest $request, Dokter $dokter)
    {
        $dokter->update($request->validated());
        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil diupdate.');
    }

    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil dihapus.');
    }
}
