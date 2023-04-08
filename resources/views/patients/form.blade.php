<form
    id="form-patient"
    method="POST"
    @if($type=="edit" ) action="{{ route('patients.update', $patient) }}" @endif
>
    @csrf

    @if ($type == "edit")
        @method('PUT')
    @endif

    <div class="col-12 mb-3">
        <div class="form-floating">
            <input
                type="text"
                name="name" id="name" class="form-control"
                placeholder="Ketik nama Pasien"
                required minlength="2" maxlength="255"

                @if ($type == "edit")
                    value="{{ $patient->name }}"
                @else
                    value="{{ old('name') }}"
                @endif
            >
            <label for="name">
                Nama Pasien
                <i class="text-danger">*</i>
            </label>
        </div>
    </div>

    <div class="col-12 mb-3">
        <div class="form-floating">
            <select name="hospital_id" id="hospital-id" class="form-select" required>
                <option value="">[Pilih Rumah Sakit]</option>
                @foreach ($hospitals as $hospital)
                    <option
                        value="{{ $hospital->id }}"
                        @if ($type == "edit")
                            @if ($hospital->id == $patient->hospital_id)
                                @selected(true)
                            @endif
                        @endif
                    >
                        {{ $hospital->name }}
                    </option>
                @endforeach
            </select>
            <label for="hospital-id">
                Rumah Sakit
                <i class="text-danger">*</i>
            </label>
        </div>
    </div>

    <div class="col-12 mb-3">
        <div class="form-floating">
            <input
                type="number"
                name="telp" id="telp" class="form-control"
                placeholder="Ketik Telepon Pasien"
                required

                @if ($type == "edit")
                    value="{{ $patient->telp }}"
                @else
                    value="{{ old('telp') }}"
                @endif
            >
            <label for="telp">
                Telepon Pasien
                <i class="text-danger">*</i>
            </label>
        </div>
    </div>

    <div class="col-12 mb-3">
        <div class="form-floating">

            @php
                if($type == "edit") {
                    $address = $patient->address;
                } else {
                    $address = old('address');
                }
            @endphp
            <textarea
                name="address" id="address" class="form-control"
                placeholder="Ketik alamat Pasien"
            >{{ $address }}</textarea>
            <label for="address">
                Alamat Pasien
                <i class="text-danger">*</i>
            </label>
        </div>
    </div>
</form>