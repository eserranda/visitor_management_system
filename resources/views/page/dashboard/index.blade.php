@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    @if (auth()->check() &&
            auth()->user()->hasRole(['security', 'super_admin', 'admin']))
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row g-5 g-xl-10 mb-xl-10">
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                    <div class="card card-flush h-md-100 mb-5 mb-xl-10">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="mb-5">Sedang Berkunjung</h3>
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $totalVisitorsActive }}</span>
                                    <span class="badge badge-light-success ">
                                        Tamu
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">
                            <a href="/visitors/pengunjung_aktif" class="fw-bold me-2 fs-4">Lihat Data</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                    <div class="card card-flush h-md-100 mb-5 mb-xl-10">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="mb-5">Total Pengunjung</h3>
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $totalVisitor }}</span>
                                    <span class="badge badge-light-success ">
                                        Tamu
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">
                            <a href="/visitors" class="fw-bold me-2 fs-4">Lihat Data</a>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                    <div class="card card-flush h-md-100 mb-5 mb-xl-10">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="mb-5">Verifikasi Tamu</h3>
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $futureVisitors }}</span>
                                    <span class="badge badge-light-success ">
                                        Tamu
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">
                            <a href="/future-visitors" class="fw-bold me-2 fs-4">Lihat Data</a>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                    <div class="card card-flush h-md-100 mb-5 mb-xl-10">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="mb-5">Total Rumah</h3>
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $totalHouse }}</span>
                                    <span class="badge badge-light-success ">
                                        Rumah
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">
                            <a href="/address" class="fw-bold me-2 fs-4">Lihat Data</a>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endif

    @if (auth()->check() &&
            auth()->user()->hasRole(['penghuni', 'super_admin']))
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row g-5 g-xl-10 mb-xl-10">
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                    <div class="card card-flush h-md-100 mb-5 mb-xl-10">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="mb-5">Sedang Berkunjung</h3>
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $visitorActiveUser }}</span>
                                    <span class="badge badge-light-success ">
                                        Tamu
                                    </span>
                                </div>
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Sedang berkunjung/bertamu</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                    <div class="card card-flush h-md-100 mb-5 mb-xl-10">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="mb-5">Total Kunjungan</h3>
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $totalvisitorUser }}</span>
                                    <span class="badge badge-light-success ">
                                        Tamu
                                    </span>
                                </div>
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Tamu yang pernah berkunjung</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                    <div class="card card-flush h-md-100 mb-5 mb-xl-10">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="mb-5">Akan Berkunjung</h3>
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $futureVisitors }}</span>
                                    <span class="badge badge-light-success ">
                                        Tamu
                                    </span>
                                </div>
                            </div>
                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Tamu yang akan berkunjung</span>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                    <div class="card card-flush h-md-100 mb-5 mb-xl-10">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="mb-5">Total Rumah</h3>
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $totalHouse }}</span>
                                    <span class="badge badge-light-success ">
                                        Rumah
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">
                            <a href="/address" class="fw-bold me-2 fs-4">Lihat Data</a>

                        </div>
                    </div>
                </div> --}}
            </div>

        </div>
    @endif
@endsection
