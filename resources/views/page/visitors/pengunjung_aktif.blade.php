@extends('layouts.master')
@push('styles')
    <link href="{{ asset('assets') }}/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

    @section('title')
        Data Pengunjung Aktif
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
                            {{-- <div class="w-100 mw-150px">
                                <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                    data-placeholder="Status" data-kt-ecommerce-product-filter="status">
                                    <option></option>
                                    <option value="all">All</option>
                                    <option value="published">Published</option>
                                    <option value="scheduled">Scheduled</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div> --}}

                            <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                                <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span
                                        class="path2"></span></i>
                                Export Data
                            </button>

                            <a href="/visitors" class="btn btn-primary">Lihat Laporan</a>
                            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                Add Data
                            </button> --}}

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
                                    <th>Pengunjung</th>
                                    <th>Tujuan</th>
                                    <th>Jenis Pengunjung</th>
                                    <th>Nomor Plat</th>
                                    <th>Waktu Kunjungan</th>
                                    <th>Waktu Keluar</th>
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

        {{-- @include('page.companies.create') --}}
        @include('page.visitors.detail')
    @endsection

    @push('scripts')
        <script src="{{ asset('assets') }}/plugins/custom/datatables/datatables.bundle.js"></script>

        <script>
            function detail(id) {
                var baseUrl = "/";
                fetch(`/visitors/detail/` + id)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('detail_name').innerHTML = data.name;
                        document.getElementById('detail_tujuan').innerHTML = data.purpose;
                        document.getElementById('detail_phone_number').innerHTML = data.phone_number;
                        document.getElementById('detail_vehicle_number').innerHTML = data.vehicle_number;
                        document.getElementById('detail_visitor_type').innerHTML = data.visitor_type + ' (' + data
                            .company_id + ')';
                        document.getElementById('detail_check_in').innerHTML = data.check_in;
                        document.getElementById('detail_check_out').innerHTML = data.check_out;
                        document.getElementById('detail_status').innerHTML = data.status;

                        let photoPreview = document.getElementById('image_show');
                        if (data.img_url) {
                            photoPreview.src = baseUrl + data.img_url;
                        } else {
                            photoPreview.src = '';
                        }
                    })
                    .catch(error => console.error(error));
                // show modal edit
                $('#detailModal').modal('show');
            }

            async function updateStatus(id, status) {
                try {
                    const response = await fetch(`/visitors/update/${id}`, {
                        method: 'PUT',
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



            var KTDatatablesExample = function() {
                var table;
                var datatable;

                var exportButtons = () => {
                    const documentTitle = 'Data Kurir/Transportasi';

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

                    const exportButtons = document.querySelectorAll('#export_menu [data-kt-export]');
                    exportButtons.forEach(exportButton => {
                        exportButton.addEventListener('click', e => {
                            e.preventDefault();

                            const exportValue = e.target.getAttribute('data-kt-export');
                            const target = document.querySelector('.dt-buttons .buttons-' +
                                exportValue);

                            if (target) {
                                target.click();
                            } else {
                                console.error('Export button not found:', exportValue);
                            }
                        });
                    });

                    $('#reload').on('click', function(e) {
                        e.preventDefault();

                        var searchInput = document.querySelector('[data-kt-filter="search"]');
                        searchInput.value = '';

                        datatable.search('').columns().search('').draw();

                        datatable.ajax.reload();
                    });
                }

                var handleSearchDatatable = () => {
                    const filterSearch = document.querySelector('[data-kt-filter="search"]');
                    filterSearch.addEventListener('keyup', function(e) {
                        datatable.search(e.target.value).draw();
                    });
                }

                return {
                    init: function() {
                        table = document.querySelector('#datatable');

                        if (!table) {
                            return;
                        }

                        datatable = $(table).DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: "{{ route('visitors.pengunjung_aktif') }}",
                            columns: [{
                                    data: 'DT_RowIndex',
                                    name: '#',
                                    searchable: false
                                },
                                {
                                    data: 'name',
                                    name: 'name',
                                    orderable: false,
                                },
                                {
                                    data: 'user_id',
                                    name: 'user_id',
                                },
                                {
                                    data: 'visitor_type',
                                    name: 'visitor_type',
                                    orderable: true,
                                },
                                {
                                    data: 'vehicle_number',
                                    name: 'vehicle_number',
                                    orderable: true,
                                },
                                {
                                    data: 'check_in',
                                    name: 'check_in',
                                    orderable: true,
                                },
                                {
                                    data: 'check_out',
                                    name: 'check_out',
                                    orderable: true,
                                },
                                {
                                    data: 'status',
                                    name: 'status',
                                    orderable: true,
                                },
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: false,
                                    searchable: false
                                },
                            ],
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

                        exportButtons();
                        handleSearchDatatable();
                    }
                };
            }();

            KTUtil.onDOMContentLoaded(function() {
                KTDatatablesExample.init();
            });
        </script>
    @endpush
