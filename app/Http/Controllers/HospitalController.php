<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHospitalRequest;
use App\Http\Requests\UpdateHospitalRequest;
use App\Models\Hospital;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hospitals = Hospital::orderByDesc('created_at')->paginate(5);
        $data['hospitals'] = $hospitals;

        $data['title'] = 'Data Rumah Sakit';

        return view('hospitals.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Tambah RS';
        $data['type'] = 'create';

        return view('hospitals.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHospitalRequest $request)
    {
        $validated = $request->validated();

        if (! $validated) {
            $output = [
                'status' => false,
                'title' => 'Terjadi kesalahan validasi',
                'text' => $validated->message(),
                'icon' => 'error',
            ];

            return response()->json($output, 422);
        }

        $data['name'] = $validated['name'];
        $data['email'] = $validated['email'];
        $data['address'] = $validated['address'];
        $data['telp'] = $validated['telp'];

        $hospital = Hospital::create($data);

        $output = [
            'status' => true,
            'title' => 'Berhasil',
            'text' => "{$hospital->name} telah dibuat",
            'icon' => 'success',
            'redirect' => route('hospitals.edit', $hospital),
        ];

        return response()->json($output, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hospital $hospital)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hospital $hospital)
    {
        $data['hospital'] = $hospital;

        $data['title'] = 'Edit RS';
        $data['type'] = 'edit';

        return view('hospitals.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHospitalRequest $request, Hospital $hospital)
    {
        $validated = $request->validated();

        if (! $validated) {
            $output = [
                'status' => false,
                'title' => 'Terjadi kesalahan validasi',
                'text' => $validated,
                'icon' => 'error',
            ];

            return response()->json($output, 422);
        }

        $hospital->name = $validated['name'];
        $hospital->email = $validated['email'];
        $hospital->address = $validated['address'];
        $hospital->telp = $validated['telp'];

        $hospital->save();

        return redirect()->route('hospitals.edit', $hospital);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hospital $hospital)
    {
        $name = $hospital->name;
        $hospital->delete();

        if ($hospital) {
            $output = [
                'status' => true,
                'title' => 'Berhasil',
                'text' => "{$name} telah dihapus",
                'icon' => 'success',
            ];

            return response()->json($output, 200);
        } else {
            $output = [
                'status' => false,
                'title' => 'Ada Kesalahan',
                'text' => "{$name} Tidak bisa dihapus",
                'icon' => 'danger',
            ];

            return response()->json($output, 500);
        }
    }
}
