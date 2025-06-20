@extends('layouts.master')
@push('styles')
    <link href="{{ asset('assets') }}/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

    @section('title')
        Data Alamat Penghuni
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
                                    class="form-control form-control-solid w-250px ps-14" placeholder="Cari data users" />
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

                            {{-- <a href="/address/create" class="btn btn-primary">Add Data</a> --}}
                            @if (auth()->check() &&
                                    auth()->user()->hasRole(['super_admin', 'admin']))
                                <button type="button" class="btn btn-primary" onclick="add()">
                                    Add Data
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
                                    <th>Pemilik Rumah</th>
                                    <th>Blok/Nomor Rumah</th>
                                    <th>Jalan</th>
                                    {{-- <th>Keterangan</th> --}}
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
        @include('page.address.create')
        @include('page.address.edit')
    @endsection

    @push('scripts')
        <script src="{{ asset('assets') }}/plugins/custom/datatables/datatables.bundle.js"></script>

        <script>
            $(document).ready(function() {
                if ($.fn.select2) {
                    $('#edit_user_id').select2({
                        dropdownParent: $('#editModal')
                    });
                }

                if ($.fn.select2) {
                    $('#user_id').select2({
                        dropdownParent: $('#addModal')
                    });
                }
            });

            function add() {
                // Kosongkan dropdown users
                const userSelect = $('#user_id');
                userSelect.empty();

                // Tambahkan placeholder option
                userSelect.append(new Option('', '', false, false));

                // Ambil data users dari server
                fetch(`/users/getAllPenghuni`)
                    .then(response => response.json())
                    .then(data => {
                        // Tambahkan users ke dropdown
                        data.forEach(user => {
                            const displayName = user.nickname || user.name;
                            userSelect.append(new Option(displayName, user.id, false, false));
                        });
                    })
                    .catch(error => console.error(error));

                $('#addModal').modal('show');
            }

            function edit(id) {
                fetch(`/address/findById/` + id)
                    .then(response => response.json())
                    .then(data => {
                        // Data alamat sekarang ada di data.address
                        document.getElementById('edit_id').value = data.address.id;
                        document.getElementById('edit_street_name').value = data.address.street_name;
                        document.getElementById('edit_house_number').value = data.address.house_number;

                        if ($.fn.select2) {
                            // Set nilai untuk block_number
                            $('#edit_block_number').val(data.address.block_number).trigger('change');

                            // Kosongkan dropdown users
                            const userSelect = $('#edit_user_id');
                            userSelect.empty();

                            // Tambahkan placeholder option
                            userSelect.append(new Option('', '', false, false));

                            // Tambahkan users ke dropdown
                            data.users.forEach(user => {
                                const displayName = user.nickname || user.name;
                                userSelect.append(new Option(displayName, user.id, false, user.id == data.address
                                    .user_id));
                            });

                            // Set nilai yang dipilih
                            userSelect.val(data.address.user_id).trigger('change');
                        }
                    })
                    .catch(error => console.error(error));

                $('#editModal').modal('show');
            }

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
                            url: "/address/destroy/" + id,
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

            var KTDatatablesExample = function() {
                var table;
                var datatable;

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
                            ajax: "{{ route('address.data') }}",
                            columns: [{
                                    data: 'DT_RowIndex',
                                    name: '#',
                                    searchable: false
                                },
                                {
                                    data: 'user_id',
                                    name: 'user_id',
                                    orderable: false,
                                },
                                {
                                    data: 'block_and_number',
                                    name: 'block_and_number'
                                },
                                {
                                    data: 'street_name',
                                    name: 'street_name',
                                    orderable: true,
                                },
                                // {
                                //     data: 'additional_info',
                                //     name: 'additional_info',
                                //     orderable: true,
                                // },
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
