<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\User;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KonsultasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Konsultasi::with(['user', 'dokter']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })->orWhereHas('dokter', function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('dokter_id')) {
            $query->where('dokter_id', $request->dokter_id);
        }

        $konsultasis = $query->orderByDesc('created_at')->paginate(10);
        $dokterList = Dokter::all();
        $userList = User::all();

        return view('konsultasi.index', compact('konsultasis', 'dokterList', 'userList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $dokters = Dokter::all();
        return view('konsultasi.create', compact('users', 'dokters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'dokter_id' => 'required|exists:dokters,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'catatan' => 'required|string|max:1000',
            'status' => 'required|in:pending,diterima,ditolak,selesai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Konsultasi::create($request->all());

        return redirect()->route('konsultasi.index')->with('success', 'Konsultasi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $konsultasi = Konsultasi::with(['user', 'dokter'])->findOrFail($id);
        return view('konsultasi.show', compact('konsultasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $konsultasi = Konsultasi::findOrFail($id);
        $users = User::all();
        $dokters = Dokter::all();
        return view('konsultasi.edit', compact('konsultasi', 'users', 'dokters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $konsultasi = Konsultasi::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'dokter_id' => 'required|exists:dokters,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'catatan' => 'required|string|max:1000',
            'status' => 'required|in:pending,diterima,ditolak,selesai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $konsultasi->update($request->all());

        return redirect()->route('konsultasi.index')->with('success', 'Konsultasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $konsultasi = Konsultasi::findOrFail($id);
        $konsultasi->delete();

        return redirect()->route('konsultasi.index')->with('success', 'Konsultasi berhasil dihapus!');
    }
}
