@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __($title) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="my-3">
                        <a
                            href="{{ route('patients.create') }}"
                            class="btn btn-primary"
                        >
                            + Tambah Pasien
                        </a>
                    </div>

                    <div class="mb-3">
                        <select name="hospital" id="hospital" class="form-select">
                            <option value="">ALL</option>
                            @foreach ($hospitals as $hospital)
                                <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="div-table-patient"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script type="module">

        let hospital = $('#hospital').val()
        $('#hospital').on('change', function(e) {
            e.preventDefault()

            hospital = $(this).val()

            loadTablePatient(hospital)
        })

        function loadTablePatient(hospital) {
            $.ajax({
                url: "{{ route('patients.table') }}",
                method: "GET",
                data: { hospital },

                success: (data)=> {
                    $('#div-table-patient').html(data)
                }
            })
        }loadTablePatient(hospital)

        window.loadTablePatient = loadTablePatient
    </script>


@endpush
