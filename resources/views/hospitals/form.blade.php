<form
    id="form-hospital"
    method="POST"
    @if($type=="edit" ) action="{{ route('hospitals.update', $hospital) }}" @endif
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
                placeholder="Ketik nama RS"
                required minlength="5" maxlength="255"

                @if ($type == "edit")
                    value="{{ $hospital->name }}"
                @else
                    value="{{ old('name') }}"
                @endif
            >
            <label for="name">
                Nama RS
                <i class="text-danger">*</i>
            </label>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-lg-6">
            <div class="form-floating">
                <input
                    type="email"
                    name="email" id="email" class="form-control"
                    placeholder="Ketik Email RS"
                    required minlength="3" maxlength="255"
    
                    @if ($type == "edit")
                        value="{{ $hospital->email }}"
                    @else
                        value="{{ old('email') }}"
                    @endif
                >
                <label for="email">
                    Email RS
                    <i class="text-danger">*</i>
                </label>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="form-floating">
                <input
                    type="number"
                    name="telp" id="telp" class="form-control"
                    placeholder="Ketik Telepon RS"
                    required
    
                    @if ($type == "edit")
                        value="{{ $hospital->telp }}"
                    @else
                        value="{{ old('telp') }}"
                    @endif
                >
                <label for="telp">
                    Telepon RS
                    <i class="text-danger">*</i>
                </label>
            </div>
        </div>
    </div>

    <div class="col-12 mb-3">
        <div class="form-floating">

            @php
                if($type == "edit") {
                    $address = $hospital->address;
                } else {
                    $address = old('address');
                }
            @endphp
            <textarea
                name="address" id="address" class="form-control"
                placeholder="Ketik alamat RS"
            >{{ $address }}</textarea>
            <label for="address">
                Alamat RS
                <i class="text-danger">*</i>
            </label>
        </div>
    </div>
</form>