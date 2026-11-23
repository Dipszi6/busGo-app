<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArmadaController extends Controller
{
    public function index(): View
    {
        $armada = Bus::withCount('jadwal')->latest()->get();
        return view('admin.armada.index', compact('armada'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama'      => ['required', 'string', 'max:100', 'unique:bus,nama'],
            'kelas'     => ['required', 'in:Executive,Sleeper'],
            'denah'     => ['required', 'in:2-2,1-1'],
            'kapasitas' => ['required', 'integer', 'min:10', 'max:60'],
            'fasilitas' => ['nullable', 'array'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ]);

        $data['fasilitas'] = $data['fasilitas'] ?? [];
        Bus::create($data);

        return back()->with('success', 'Armada bus baru berhasil ditambahkan.');
    }

    public function update(Request $request, Bus $bus): RedirectResponse
    {
        $data = $request->validate([
            'nama'      => ['required', 'string', 'max:100', 'unique:bus,nama,' . $bus->id],
            'kelas'     => ['required', 'in:Executive,Sleeper'],
            'denah'     => ['required', 'in:2-2,1-1'],
            'kapasitas' => ['required', 'integer', 'min:10', 'max:60'],
            'fasilitas' => ['nullable', 'array'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ]);

        $data['fasilitas'] = $data['fasilitas'] ?? [];
        $bus->update($data);

        return back()->with('success', 'Data armada berhasil diperbarui.');
    }

    public function destroy(Bus $bus): RedirectResponse
    {
        if ($bus->jadwal()->exists()) {
            return back()->withErrors(['armada' => 'Armada tidak dapat dihapus karena masih memiliki jadwal aktif/terdaftar.']);
        }

        $bus->delete();
        return back()->with('success', 'Armada berhasil dihapus.');
    }
}
