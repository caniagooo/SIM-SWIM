<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Wilayah\Provinsi;
use App\Models\Wilayah\Kota;
use App\Models\Wilayah\Kecamatan;
use App\Models\Wilayah\Kelurahan;

class AlamatSelect extends Component
{
    public $provinsi_id, $kota_id, $kecamatan_id, $kelurahan_id, $address_line;

    public $provinsiList = [], $kotaList = [], $kecamatanList = [], $kelurahanList = [];

    public function mount()
    {
        $this->provinsiList = Provinsi::orderBy('nama')->get();
    }

    public function updatedProvinsiId($id)
    {
        $this->kotaList = Kota::where('provinsi_id', $id)->orderBy('nama')->get();
        $this->kota_id = $this->kecamatan_id = $this->kelurahan_id = null;
        $this->kecamatanList = $this->kelurahanList = [];
    }

    public function updatedKotaId($id)
    {
        $this->kecamatanList = Kecamatan::where('kota_id', $id)->orderBy('nama')->get();
        $this->kecamatan_id = $this->kelurahan_id = null;
        $this->kelurahanList = [];
    }

    public function updatedKecamatanId($id)
    {
        $this->kelurahanList = Kelurahan::where('kecamatan_id', $id)->orderBy('nama')->get();
        $this->kelurahan_id = null;
    }

    public function save()
    {
        $this->validate([
            'provinsi_id' => 'required',
            'kota_id' => 'required',
            'kecamatan_id' => 'required',
            'kelurahan_id' => 'required',
            'address_line' => 'required|string|max:255',
        ]);

        auth()->user()->update([
            'kelurahan_id' => $this->kelurahan_id,
            'address_line' => $this->address_line,
        ]);

        session()->flash('message', 'Alamat berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.alamat-select');
    }
}

