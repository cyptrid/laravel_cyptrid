<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Hospital;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hospitals = Hospital::orderByDesc('created_at')->get();
        $data['hospitals'] = $hospitals;

        $data['title'] = 'Data Pasien';

        return view('patients.index', $data);
    }

    public function table(Request $request)
    {
        $patients = Patient::orderByDesc('created_at');

        if (! empty($request->hospital)) {
            $patients->where('hospital_id', $request->hospital);
        }
        $patients = $patients->get();

        $data['patients'] = $patients;

        return view('patients.table', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hospitals = Hospital::orderByDesc('created_at')->get();
        $data['hospitals'] = $hospitals;

        $data['title'] = 'Tambah Pasien';
        $data['type'] = 'create';

        return view('patients.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
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
        $data['hospital_id'] = $validated['hospital_id'];
        $data['address'] = $validated['address'];
        $data['telp'] = $validated['telp'];

        $patient = Patient::create($data);

        $output = [
            'status' => true,
            'title' => 'Berhasil',
            'text' => "{$patient->name} telah dibuat",
            'icon' => 'success',
            'redirect' => route('patients.edit', $patient),
        ];

        return response()->json($output, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $data['patient'] = $patient;

        $hospitals = Hospital::orderByDesc('created_at')->get();
        $data['hospitals'] = $hospitals;

        $data['title'] = 'Edit Pasien';
        $data['type'] = 'edit';

        return view('patients.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
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

        $patient->name = $validated['name'];
        $patient->hospital_id = $validated['hospital_id'];
        $patient->address = $validated['address'];
        $patient->telp = $validated['telp'];

        $patient->save();

        return redirect()->route('patients.edit', $patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $name = $patient->name;
        $patient->delete();

        if ($patient) {
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
