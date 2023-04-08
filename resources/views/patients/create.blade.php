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

                    @include('patients.form')

                </div>

                <div class="card-footer">
                    <div class="d-flex">
                        <div class="p-1">
                            <a
                                href="{{ route('patients.index') }}"
                                class="btn btn-warning"
                            >
                                Kembali
                            </a>
                        </div>

                        <div class="p-1">
                            <button
                                type="submit"
                                form="form-patient"
                                class="btn btn-primary"
                            >
                                Simpan
                            </button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="module">
    $('#form-patient').on('submit', function(e) {
        e.preventDefault()

        Swal.fire({
            title: `Simpan data Pasien?`,
            text: `Data Pasien akan disimpan ke Database`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan sekarang!',
            cancelButtonText: 'Batal...',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn-primary',
                cancelButton: 'btn-secondary'
            },
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false
        }).then((result)=> {
            if(result.value) {
                
                $.ajax({
                    url: "{{ route('patients.store') }}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,

                    beforeSend: ()=> {
                        Swal.fire({
                            title: "Mohon Tunggu",
                            text: "Proses Memakan Waktu",
                            didOpen: ()=> {
                                Swal.showLoading()
                            }
                        })
                    },

                    success: (data)=> {
                        Swal.fire({
                            title: data.title,
                            text: data.text,
                            icon: data.icon
                        }).then(() => {
                            if(data.status) {

                                location.href = data.redirect
                            }
                        })
                    }
                })
            }
        })
    })
</script>
@endpush
