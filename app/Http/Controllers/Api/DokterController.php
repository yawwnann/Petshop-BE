<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokter;

class DokterController extends Controller
{
    // GET /api/dokters - daftar semua dokter
    public function index()
    {
        $dokters = Dokter::all();
        return response()->json($dokters);
    }
}