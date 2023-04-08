<div class="table-responsive">
    <table class="table table-sm table-bordered table-hover w-100" id="table-hospital">
        <thead class="table-secondary">
            <tr>
                <th class="text-end">No</th>
                <th>Nama Pasien</th>
                <th>Rumah Sakit</th>
                <th>Deskripsi</th>
                <th>Menu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr>
                    <td class="text-end">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $patient->name }}
                    </td>
                    <td>
                        {!! $patient->hospital->name ?? '<i>Kosong</i>' !!}
                    </td>

                    <td>
                        <ul>
                            <li>Telepon: {{ $patient->telp }}</li>
                            <li>
                                Alamat:
                                <p>
                                    {{ $patient->address }}
                                </p>
                            </li>
                        </ul>
                    </td>

                    <td>
                        <div class="d-flex">
                            <div class="p-1">
                                <a
                                    href="{{ route('patients.edit', $patient->id) }}"
                                    class="btn btn-sm btn-warning"
                                    data-id="{{ $patient->id }}"
                                >
                                    EDIT
                                </a>
                            </div>

                            <div class="p-1">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-danger btn-delete"
                                    data-id="{{ $patient->id }}"
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

<script type="module">
    $('.btn-delete').on('click', function(e) {
            e.preventDefault()
            var id = $(this).data('id')

            Swal.fire({
                title: `Hapus data Pasien?`,
                text: `Data Pasien akan dihapus permanen`,
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
                        url: `patients/${id}`,
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
                                    loadTablePatient('')
                                }
                            })
                        }
                    })
                }
            })
        })
</script>