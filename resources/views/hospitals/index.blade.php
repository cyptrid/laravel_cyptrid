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
                            href="{{ route('hospitals.create') }}"
                            class="btn btn-primary"
                        >
                            + Tambah RS
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover w-100" id="table-hospital">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-end">No</th>
                                    <th>Nama RS</th>
                                    <th>Deskripsi</th>
                                    <th>Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hospitals as $hospital)
                                    <tr>
                                        <td class="text-end">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            {{ $hospital->name }}
                                        </td>

                                        <td>
                                            <ul>
                                                <li>Telepon: {{ $hospital->telp }}</li>
                                                <li>Email: {{ $hospital->email }}</li>
                                                <li>
                                                    Alamat:
                                                    <p>
                                                        {{ $hospital->address }}
                                                    </p>
                                                </li>
                                            </ul>
                                        </td>

                                        <td>
                                            <div class="d-flex">
                                                <div class="p-1">
                                                    <a
                                                        href="{{ route('hospitals.edit', $hospital->id) }}"
                                                        class="btn btn-sm btn-warning"
                                                        data-id="{{ $hospital->id }}"
                                                    >
                                                        EDIT
                                                    </a>
                                                </div>

                                                <div class="p-1">
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-danger btn-delete"
                                                        data-id="{{ $hospital->id }}"
                                                    >
                                                        HAPUS
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $hospitals->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script type="module">

        $('.btn-delete').on('click', function(e) {
            e.preventDefault()
            var id = $(this).data('id')

            Swal.fire({
                title: `Hapus data RS?`,
                text: `Data RS akan dihapus permanen`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus sekarang!',
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
                        url: `hospitals/${id}`,
                        method: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },

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
                                    location.reload()
                                }
                            })
                        }
                    })
                }
            })
        })
    </script>

@endpush
