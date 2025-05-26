@extends('layouts.master')
@push('styles')
    <link href="{{ asset('assets') }}/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

    @section('title')
        Data Tamu Anda Yang Akan Berkunjung
    @endsection

    @section('content')
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card card-flush">
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                                <input type="text" data-kt-filter="search"
                                    class="form-control form-control-solid w-250px ps-14" placeholder="Cari data" />
                            </div>
                        </div>

                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            <div class="w-100 mw-150px">
                                <select class="form-select form-select-solid" data-hide-search="true" id="filterData">
                                    <option value="" selected disabled>Filter</option>
                                    <option value="pending">Akan Berkunjung</option>
                                    <option value="approved">Sedang Berkunjung</option>
                                    <option value="completed">Selesai</option>
                                    <option value="all">Semua</option>
                                </select>
                            </div>

                            <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                                <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span
                                        class="path2"></span></i>
                                Export Data
                            </button>

                            {{-- <button type="button" class="btn btn-primary" onclick="create()">
                                Add
                            </button> --}}
                            @if (auth()->check() &&
                                    auth()->user()->hasRole(['penghuni', 'super_admin', 'admin']))
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addModal">
                                    Add
                                </button>
                            @endif

                            <div id="export_menu"
                                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                                data-kt-menu="true">

                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-export="excel">
                                        Excel
                                    </a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-export="pdf">
                                        PDF
                                    </a>
                                </div>
                            </div>
                            <div id="buttons" class="d-none"></div>

                            <a href="#" class="btn btn-icon btn-light btn-active-light-primary" id="reload">
                                <i class="ki-duotone
                            ki-arrows-circle">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </a>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5 datatable" id="datatable">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th>No</th>
                                    <th>Nama Tamu</th>
                                    <th>Tujuan</th>
                                    <th>Blok</th>
                                    <th>Estimasi Kunjungan</th>
                                    <th>No. Plat Kendaraan</th>
                                    <th>Verifikasi</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @include('page.future-visitor.create')
        @include('page.future-visitor.detail')
        {{-- @include('page.future-visitor.edit') --}}
    @endsection

    @push('scripts')
        <script src="{{ asset('assets') }}/plugins/custom/datatables/datatables.bundle.js"></script>

        <script>
            function hapus(id) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "/future-visitors/destroy/" + id,
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                $('#datatable').DataTable().ajax.reload();
                                Swal.fire(
                                    'Terhapus!',
                                    'Data berhasil dihapus.',
                                    'success'
                                )
                            }
                        });
                    }
                })
            }

            async function detail(id) {
                var baseUrl = "/";
                await fetch(`/future-visitors/detail/` + id)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('detail_id').value = data.id;
                        document.getElementById('detail_visitor_name').innerHTML = data.visitor_name;
                        document.getElementById('detail_arrival_date').innerHTML = data.arrival_date;
                        document.getElementById('detail_vehicle_type').innerHTML = data.vehicle_type;
                        document.getElementById('detail_vehicle_number').innerHTML = data.vehicle_number;
                        document.getElementById('detail_estimated_arrival_time').innerHTML = data
                            .estimated_arrival_time;
                        // document.getElementById('detail_status').innerHTML = data.status;
                        document.getElementById('detail_verify_status').innerHTML = data.verify_status;
                        document.getElementById('detail_check_in').innerHTML = data.check_in;
                        document.getElementById('detail_check_out').innerHTML = data.check_out;

                        let photoPreview = document.getElementById('image_show');
                        if (data.img_url) {
                            photoPreview.src = baseUrl + data.img_url;
                        } else {
                            photoPreview.src = '';
                        }
                    })
                    .catch(error => console.error(error));
                $('#detailModal').modal('show');
            }

            async function updateStatus(id, status) {
                try {
                    const response = await fetch(`/future-visitors/update-status/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status
                        })
                    });

                    // Pastikan HTTP response sukses  
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const data = await response.json();

                    if (!data.success) {
                        toastr.error(data.message);
                    } else {
                        toastr.success(data.message);
                        $('#datatable').DataTable().ajax.reload();
                    }
                } catch (error) {
                    console.error(error);
                    toastr.error('Terjadi kesalahan saat memproses permintaan');
                }
            }

            async function rejected(id) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                try {
                    const response = await fetch('/future-visitors/visitor-verification/' + id, {
                        method: 'PUT',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            status: 0
                        }),
                    });

                    const data = await response.json();
                    console.log(data);
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Tamu berhasil ditolak!',
                        });
                        // reload datatable
                        $('#datatable').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Something went wrong!',
                        });
                    }
                } catch (error) {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat memverifikasi tamu.',
                    });
                }
            }

            var KTDatatablesExample = function() {
                // Variabel untuk menyimpan referensi tabel
                var table;
                var datatable;

                // Hook export buttons
                var exportButtons = () => {
                    const documentTitle = 'Data Tamu Yang Akan Berkunjung';

                    var buttons = new $.fn.dataTable.Buttons(datatable, {
                        buttons: [{
                                extend: 'excelHtml5',
                                title: documentTitle
                            },

                            {
                                extend: 'pdfHtml5',
                                title: documentTitle
                            }
                        ]
                    }).container().appendTo($('#buttons'));

                    // Hook dropdown menu click event to datatable export buttons
                    const exportButtons = document.querySelectorAll('#export_menu [data-kt-export]');
                    exportButtons.forEach(exportButton => {
                        exportButton.addEventListener('click', e => {
                            e.preventDefault();

                            // Get clicked export value
                            const exportValue = e.target.getAttribute('data-kt-export');
                            const target = document.querySelector('.dt-buttons .buttons-' +
                                exportValue);

                            // Trigger click event on hidden datatable export buttons
                            if (target) {
                                target.click();
                            } else {
                                console.error('Export button not found:', exportValue);
                            }
                        });
                    });

                    $('#filterData').on('change', function() {
                        var value = $(this).val();
                        if (value == 'pending') {
                            datatable.ajax.url("{{ route('future-visitors.data') }}?filter=pending")
                                .load();
                        } else if (value == 'approved') {
                            datatable.ajax.url("{{ route('future-visitors.data') }}?filter=approved")
                                .load();
                        } else if (value == 'completed') {
                            datatable.ajax.url("{{ route('future-visitors.data') }}?filter=completed")
                                .load();
                        } else {
                            datatable.ajax.url("{{ route('future-visitors.data') }}").load();
                        }
                    });

                    $('#reload').on('click', function(e) {
                        e.preventDefault();

                        // Hapus teks yang ada di input search
                        var searchInput = document.querySelector('[data-kt-filter="search"]');
                        searchInput.value = '';

                        // Reset filter DataTable
                        datatable.search('').columns().search('').draw();

                        // Load ulang data dari server
                        // datatable.ajax.reload();
                        datatable.ajax.url("{{ route('future-visitors.data') }}").load();


                        // Jika menggunakan event keyup untuk pencarian, trigger event
                        // $(searchInput).trigger('keyup');
                    });
                }

                var handleSearchDatatable = () => {
                    const filterSearch = document.querySelector('[data-kt-filter="search"]');
                    filterSearch.addEventListener('keyup', function(e) {
                        datatable.search(e.target.value).draw();
                    });
                }

                // Public methods
                return {
                    init: function() {
                        table = document.querySelector('#datatable');

                        if (!table) {
                            return;
                        }

                        // Inisialisasi DataTable
                        datatable = $(table).DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: "{{ route('future-visitors.data') }}",
                            columns: [{
                                    data: 'DT_RowIndex',
                                    name: '#',
                                    searchable: false
                                },
                                {
                                    data: 'visitor_name',
                                    name: 'visitor_name',
                                    orderable: false,
                                },
                                {
                                    data: 'user_id',
                                    name: 'user_id',
                                },
                                {
                                    data: 'address',
                                    name: 'address',
                                },
                                {
                                    data: 'estimated_arrival_time',
                                    name: 'estimated_arrival_time',
                                    orderable: true,
                                },
                                {
                                    data: 'vehicle_number',
                                    name: 'vehicle_number'
                                },
                                {
                                    data: 'verify_status',
                                    name: 'verify_status',
                                },
                                {
                                    data: 'status',
                                    name: 'status',
                                },
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: false,
                                    searchable: false
                                },
                            ],
                            // dom: `<'row'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-md-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-md-end'>>t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>`,
                            // dom: 'Bfrtip',
                            buttons: [{
                                    extend: 'excel',
                                    className: 'btn btn-secondary',
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                                    }
                                },
                                {
                                    extend: 'print',
                                    className: 'btn btn-secondary',
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                                    }
                                }
                            ]
                        });

                        // Panggil exportButtons setelah DataTable diinisialisasi
                        exportButtons();
                        handleSearchDatatable();
                    }
                };
            }();

            // On document ready
            KTUtil.onDOMContentLoaded(function() {
                KTDatatablesExample.init();
            });


            // function create() {
            //     fetch(`/users/getAll`)
            //         .then(response => response.json())
            //         .then(data => {
            //             console.log(data);
            //             let options = '<option value="" selected disabled>Pilih Tamu</option>';
            //             data.forEach(user => {
            //                 options += `<option value="${user.id}">${user.name}</option>`;
            //             });
            //             document.getElementById('name').innerHTML = options;
            //         })
            //         .catch(error => console.error(error));
            //     // show modal edit
            //     $('#AddModal').modal('show');
            // }
        </script>


    @endpush
