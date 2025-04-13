@extends('layouts.master')
@push('styles')
    <link href="{{ asset('assets') }}/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

    @section('title')
        Data Users
    @endsection

    @section('content')
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Products-->
                <div class="card card-flush">
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                                <input type="text" data-kt-filter="search"
                                    class="form-control form-control-solid w-250px ps-14" placeholder="Cari data users" />
                            </div>
                        </div>

                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            <div class="w-100 mw-150px">
                                <!--begin::Select2-->
                                <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                    data-placeholder="Status" data-kt-ecommerce-product-filter="status">
                                    <option></option>
                                    <option value="all">All</option>
                                    <option value="published">Published</option>
                                    <option value="scheduled">Scheduled</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <!--end::Select2-->
                            </div>

                            <!--begin::Export dropdown-->
                            <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                                <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span
                                        class="path2"></span></i>
                                Export Data
                            </button>

                            <a href="/users/add" class="btn btn-primary">Add Data</a>
                            <!--begin::Menu-->
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
                            <!--begin::Hide default export buttons-->
                            <div id="buttons" class="d-none"></div>
                            <!--end::Hide default export buttons-->

                            <a href="#" class="btn btn-icon btn-light btn-active-light-primary" id="reload">
                                <i class="ki-duotone
                                ki-arrows-circle">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </a>


                        </div>
                    </div>

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5 datatable" id="datatable">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Nick Name</th>
                                    <th>Email</th>
                                    <th>No Hp</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">

                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Products-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    @endsection

    @push('scripts')
        <script src="{{ asset('assets') }}/plugins/custom/datatables/datatables.bundle.js"></script>

        <script>
            // $(document).ready(function() {
            //     // $('#search').on('click', function() {
            //     //     var selectedKelas = $('#filterKelas').val();
            //     //     var selectedTanggal = $('#filterTanggal').val();
            //     //     if (!selectedKelas && !selectedTanggal) {
            //     //         alert('Pilih kelas atau tanggal terlebih dahulu');
            //     //         return;
            //     //     }
            //     //     const url = '/users/search?kelas=' + selectedKelas + '&tanggal=' +
            //     //         selectedTanggal;
            //     //     myDataTable.ajax.url(url).load();
            //     // });

            //     // $('#reload').on('click', function() {
            //     //     $('#filterTanggal').val('');
            //     //     $('#filterKelas').val('');
            //     //     myDataTable.ajax.url('/users/data').load();
            //     // });
            //     KTDatatablesExample.init();


            // });


            var KTDatatablesExample = function() {
                // Variabel untuk menyimpan referensi tabel
                var table;
                var datatable;

                // Hook export buttons
                var exportButtons = () => {
                    const documentTitle = 'Customer Orders Report';

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

                    $('#reload').on('click', function(e) {
                        e.preventDefault();

                        // Hapus teks yang ada di input search
                        var searchInput = document.querySelector('[data-kt-filter="search"]');
                        searchInput.value = '';

                        // Reset filter DataTable
                        datatable.search('').columns().search('').draw();

                        // Load ulang data dari server
                        datatable.ajax.reload();

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
                            ajax: "{{ route('users.data') }}",
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
                                    data: 'username',
                                    name: 'username'
                                },
                                {
                                    data: 'nickname',
                                    name: 'nickname',
                                    orderable: true,
                                },
                                {
                                    data: 'email',
                                    name: 'email'
                                },
                                {
                                    data: 'phone_number',
                                    name: 'phone_number'
                                },
                                {
                                    data: 'status',
                                    name: 'status'
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
                            url: "/users/destroy/" + id,
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                $('#datatable').DataTable().ajax.reload();
                                toastr.success('Data berhasil dihapus', 'Success');
                            }
                        });
                    }
                })
            }
        </script>
    @endpush
