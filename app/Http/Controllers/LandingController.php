<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $armada = [
            ['nama' => 'Executive Class', 'deskripsi' => 'Nyaman untuk perjalanan jauh',          'warna' => 'hijau'],
            ['nama' => 'Sleeper Class',   'deskripsi' => 'Istirahat lebih nyaman di perjalanan', 'warna' => 'oranye'],
            ['nama' => 'First Class',     'deskripsi' => 'Pengalaman perjalanan premium',        'warna' => 'hijau'],
        ];

        return view('landing', compact('armada'));
    }
}
