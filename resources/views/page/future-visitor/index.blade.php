@extends('layouts.master')
@push('styles')
    <link href="{{ asset('assets') }}/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

    @section('title')
        Data Tamu Yang Akan Berkunjung
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
                                <select class="form-select form-select-solid" data-hide-search="true" data-placeholder="Laporan"
                                    id="filterData">
                                    <option value="" selected disabled>Filter</option>
                                    <option value="weekly">Akan Berkunjung</option>
                                    <option value="monthly">Selesai</option>
                                    <option value="weekly">Semua</option>
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                Add
                            </button>

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
                                    <th>Tanggal</th>
                                    <th>Estimasi Jam Kunjungan</th>
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
        {{-- @include('page.future-visitor.edit') --}}
    @endsection

    @push('scripts')
        <script>
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
