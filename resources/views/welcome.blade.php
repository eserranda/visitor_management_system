<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="" />
    <title>Visitor Management System Perumahan</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="/" />
    <meta property="og:site_name" content="VMS | Visitor Management System" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <link rel="canonical" href="https://preview.keenthemes.com/metronic8" /> -->
    <link rel="shortcut icon" href="{{ asset('assets') }}/media/logos/favicon.ico" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets') }}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu"
    class="bg-white position-relative app-blank">
    <!--begin::Theme mode setup on page load-->

    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Header Section-->
        <div class="mb-0" id="home">
            <!--begin::Wrapper-->
            <div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom landing-dark-bg"
                style="background-image: url(assets/media/svg/illustrations/landing.svg)">
                <!--begin::Header-->
                <div class="landing-header" data-kt-sticky="true" data-kt-sticky-name="landing-header"
                    data-kt-sticky-offset="{default: '200px', lg: '300px'}">
                    <!--begin::Container-->
                    <div class="container">
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center justify-content-between">
                            <!--begin::Logo-->
                            <div class="d-flex align-items-center flex-equal">
                                <!--begin::Mobile menu toggle-->
                                <button class="btn btn-icon btn-active-color-primary me-3 d-flex d-lg-none"
                                    id="kt_landing_menu_toggle">
                                    <i class="ki-outline ki-abstract-14 fs-2hx"></i>
                                </button>
                                <!--end::Mobile menu toggle-->
                                <!--begin::Logo image-->
                                <a href="/">
                                    <img alt="Logo" src="{{ asset('assets') }}/media/logos/favicon.ico"
                                        class="logo-default h-25px h-lg-30px" />
                                    {{-- <img alt="Logo" src="assets/media/logos/landing-dark.svg"
                                        class="logo-sticky h-20px h-lg-25px" /> --}}
                                </a>
                                <!--end::Logo image-->
                            </div>
                            <!--end::Logo-->
                            <!--begin::Menu wrapper-->
                            <div class="d-lg-block" id="kt_header_nav_wrapper">
                                <div class="d-lg-block p-5 p-lg-0" data-kt-drawer="true"
                                    data-kt-drawer-name="landing-menu"
                                    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                                    data-kt-drawer-width="200px" data-kt-drawer-direction="start"
                                    data-kt-drawer-toggle="#kt_landing_menu_toggle" data-kt-swapper="true"
                                    data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav_wrapper'}">
                                    <!--begin::Menu-->
                                    <div class="menu menu-column flex-nowrap menu-rounded menu-lg-row menu-title-gray-500 menu-state-title-primary nav nav-flush fs-5 fw-semibold"
                                        id="kt_landing_menu">
                                        <!--begin::Menu item-->
                                        <div class="menu-item">
                                            <!--begin::Menu link-->
                                            <a class="menu-link nav-link active py-3 px-4 px-xxl-6" href="#clients"
                                                data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">
                                                Daftar
                                            </a>
                                            <!--end::Menu link-->
                                        </div>

                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
                            </div>
                            <!--end::Menu wrapper-->
                            <!--begin::Toolbar-->
                            <div class="flex-equal text-end ms-1">
                                <a href="/auth/login" class="btn btn-success">Login</a>
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->
                {{-- <!--begin::Landing hero-->
                <div class="d-flex flex-column flex-center w-100 min-h-350px min-h-lg-500px px-9">
                    <!--begin::Heading-->
                    <div class="text-center mb-5 mb-lg-10 py-10 py-lg-20">
                        <!--begin::Title-->
                        <h1 class="text-white lh-base fw-bold fs-2x fs-lg-3x mb-15">Build An Outstanding Solutions
                            <br />with
                            <span
                                style="background: linear-gradient(to right, #12CE5D 0%, #FFD80C 100%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;">
                                <span id="kt_landing_hero_text">The Best Theme Ever</span>
                            </span>
                        </h1>
                        <!--end::Title-->
                        <!--begin::Action-->
                        <a href="../../demo25/dist/index.html" class="btn btn-primary">Try Metronic</a>
                        <!--end::Action-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Clients-->
                    <div class="d-flex flex-center flex-wrap position-relative px-5">
                        <!--begin::Client-->
                        <div class="d-flex flex-center m-3 m-md-6" data-bs-toggle="tooltip" title="Fujifilm">
                            <img src="assets/media/svg/brand-logos/fujifilm.svg" class="mh-30px mh-lg-40px"
                                alt="" />
                        </div>
                        <!--end::Client-->
                        <!--begin::Client-->
                        <div class="d-flex flex-center m-3 m-md-6" data-bs-toggle="tooltip" title="Vodafone">
                            <img src="assets/media/svg/brand-logos/vodafone.svg" class="mh-30px mh-lg-40px"
                                alt="" />
                        </div>
                        <!--end::Client-->
                        <!--begin::Client-->
                        <div class="d-flex flex-center m-3 m-md-6" data-bs-toggle="tooltip"
                            title="KPMG International">
                            <img src="assets/media/svg/brand-logos/kpmg.svg" class="mh-30px mh-lg-40px"
                                alt="" />
                        </div>
                        <!--end::Client-->
                        <!--begin::Client-->
                        <div class="d-flex flex-center m-3 m-md-6" data-bs-toggle="tooltip" title="Nasa">
                            <img src="assets/media/svg/brand-logos/nasa.svg" class="mh-30px mh-lg-40px"
                                alt="" />
                        </div>
                        <!--end::Client-->
                        <!--begin::Client-->
                        <div class="d-flex flex-center m-3 m-md-6" data-bs-toggle="tooltip" title="Aspnetzero">
                            <img src="assets/media/svg/brand-logos/aspnetzero.svg" class="mh-30px mh-lg-40px"
                                alt="" />
                        </div>
                        <!--end::Client-->
                        <!--begin::Client-->
                        <div class="d-flex flex-center m-3 m-md-6" data-bs-toggle="tooltip"
                            title="AON - Empower Results">
                            <img src="assets/media/svg/brand-logos/aon.svg" class="mh-30px mh-lg-40px"
                                alt="" />
                        </div>
                        <!--end::Client-->
                        <!--begin::Client-->
                        <div class="d-flex flex-center m-3 m-md-6" data-bs-toggle="tooltip" title="Hewlett-Packard">
                            <img src="assets/media/svg/brand-logos/hp-3.svg" class="mh-30px mh-lg-40px"
                                alt="" />
                        </div>
                        <!--end::Client-->
                        <!--begin::Client-->
                        <div class="d-flex flex-center m-3 m-md-6" data-bs-toggle="tooltip" title="Truman">
                            <img src="assets/media/svg/brand-logos/truman.svg" class="mh-30px mh-lg-40px"
                                alt="" />
                        </div>
                        <!--end::Client-->
                    </div>
                    <!--end::Clients-->
                </div>
                <!--end::Landing hero--> --}}
            </div>
            <!--end::Wrapper-->
            <!--begin::Curve bottom-->
            <div class="landing-curve landing-dark-color mb-2 mb-lg-2">
                <svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z"
                        fill="currentColor"></path>
                </svg>
            </div>
            <!--end::Curve bottom-->
        </div>

        <!--begin::Testimonials Section-->
        <div class="mt-5 mb-n20 position-relative z-index-2">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Heading-->
                <div class="text-center mb-17">
                    <!--begin::Title-->
                    <h3 class="fs-2hx text-dark mb-5" data-kt-scroll-offset="{default: 125, lg: 150}">
                        Mendaftar Sebagi Pengunjung</h3>
                    <!--end::Title-->
                    <!--begin::Description-->
                    <div class="fs-5 text-muted fw-bold">
                        Silahkan isi form pendaftaran untuk menjadi pengunjung di Perumahan kami.
                    </div>
                    <!--end::Description-->
                </div>
                <div class="card-rounded shadow p-8 p-lg-12 mb-n5 mb-lg-n13"
                    style="background: linear-gradient(90deg, #20AA3E 0%, #03A588 100%);" id="clients">
                    <!--begin::Content-->
                    <div class="my-2 me-5">
                        <form id="addForm">
                            <div class="modal-body">
                                <div class="row mb-5">
                                    <div class="col-md-4 fv-row">
                                        <label class="required fs-5 fw-semibold mb-2">Tujuan</label>
                                        <select class="form-select" name="user_id" id="user_id">
                                            <option selected disabled>- Pilih tujuan/pemilik rumah -</option>
                                            @foreach ($addresses as $address)
                                                <option value="{{ $address->user_id }}">
                                                    {{ $address->user->name }} -
                                                    Blok {{ $address->block_number }} No.
                                                    {{ $address->house_number }}
                                                </option>
                                            @endforeach
                                            {{-- @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} -
                                                    {{ $user->block_number }}</option>
                                            @endforeach --}}

                                            <div class="invalid-feedback"> </div>
                                        </select>
                                    </div>
                                    <div class="col-md-4 fv-row">
                                        <label class="required fs-5 fw-semibold mb-2">Nama Tamu</label>
                                        <input type="text" class="form-control" placeholder="Nama Tamu"
                                            name="visitor_name" id="visitor_name" />
                                        <div class="invalid-feedback"> </div>
                                    </div>
                                    <div class="col-md-4 fv-row">
                                        <label class="required fs-5 fw-semibold mb-2">Tanggal berkunjung</label>
                                        <input type="date" class="form-control" placeholder="Tanggal"
                                            name="arrival_date" id="arrival_date" />
                                        <div class="invalid-feedback"> </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-4 fv-row">
                                        <label class="required fs-5 fw-semibold mb-2">Jam (Estimasi waktu
                                            kedatangan)</label>
                                        <input type="time" class="form-control"
                                            placeholder="estimated_arrival_time" name="estimated_arrival_time"
                                            id="purpose" />
                                        <div class="invalid-feedback"> </div>
                                    </div>
                                    <div class="col-md-4 fv-row">
                                        <label class="fs-5 fw-semibold mb-2 required">Jenis Kendaraan</label>
                                        <select class="form-select" name="vehicle_type" id="vehicle_type">
                                            <option selected disabled>- Pilih jenis kendaraan -</option>
                                            <option value="Mobil">Mobil</option>
                                            <option value="Motor">Motor</option>
                                            <div class="invalid-feedback"> </div>
                                        </select>
                                    </div>
                                    <div class="col-md-4 fv-row">
                                        <label class="fs-5 fw-semibold mb-2 required">Nomor Plat Kendaraan</label>
                                        <input type="text" class="form-control" placeholder="Plat kendaraan"
                                            name="vehicle_number" id="vehicle_number" />
                                        <div class="invalid-feedback"> </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-4 fv-row">
                                        <label class="fs-5 fw-semibold mb-2 required">No. Telp</label>
                                        <input type="text" class="form-control" placeholder="Nomor Telepon"
                                            name="phone_number" id="phone_number" />
                                        <div class="invalid-feedback"> </div>
                                    </div>
                                    <div class="col-md-4 fv-row">
                                        <label class="fs-5 fw-semibold mb-2 required">Foto Tamu</label>
                                        <input type="file" class="form-control" name="captured_image"
                                            id="captured_image" />
                                        <div class="invalid-feedback"> </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-light mx-3"
                                    data-bs-dismiss="modal">Close</button> --}}
                                <button type="submit" id="submitBtn" class="btn btn-primary">
                                    <span id="btnText">Simpan</span>
                                    <span id="btnSpinner" class="spinner-border spinner-border-sm d-none"
                                        role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--end::Highlight-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Testimonials Section-->
    </div>
    <!--end::Testimonials Section-->
    <!--begin::Footer Section-->
    {{-- <div class="mb-0">
            <!--begin::Curve top-->
            <div class="landing-curve landing-dark-color">
                <svg viewBox="15 -1 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M1 48C4.93573 47.6644 8.85984 47.3311 12.7725 47H1489.16C1493.1 47.3311 1497.04 47.6644 1501 48V47H1489.16C914.668 -1.34764 587.282 -1.61174 12.7725 47H1V48Z"
                        fill="currentColor"></path>
                </svg>
            </div>
            <!--end::Curve top-->
            <!--begin::Wrapper-->
            <div class="landing-dark-bg pt-20">
                <div class="container">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column flex-md-row flex-stack py-7 py-lg-10">
                        <!--begin::Copyright-->
                        <div class="d-flex align-items-center order-2 order-md-1">
                            <!--begin::Logo-->
                            <a href="../../demo25/dist/landing.html">
                                <img alt="Logo" src="assets/media/logos/landing.svg" class="h-15px h-md-20px" />
                            </a>
                            <!--end::Logo image-->
                            <!--begin::Logo image-->
                            <span class="mx-5 fs-6 fw-semibold text-gray-600 pt-1"
                                href="https://keenthemes.com">&copy;
                                2023 Keenthemes Inc.</span>
                            <!--end::Logo image-->
                        </div>
                        <!--end::Copyright-->
                        <!--begin::Menu-->
                        <ul
                            class="menu menu-gray-600 menu-hover-primary fw-semibold fs-6 fs-md-5 order-1 mb-5 mb-md-0">
                            <li class="menu-item">
                                <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
                            </li>
                            <li class="menu-item mx-5">
                                <a href="https://devs.keenthemes.com" target="_blank"
                                    class="menu-link px-2">Support</a>
                            </li>
                            <li class="menu-item">
                                <a href="" target="_blank" class="menu-link px-2">Purchase</a>
                            </li>
                        </ul>
                        <!--end::Menu-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Wrapper-->
        </div> --}}
    <!--end::Footer Section-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-outline ki-arrow-up"></i>
    </div>
    <!--end::Scrolltop-->
    </div>

    <script>
        document.getElementById('addForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const form = event.target;
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');
            const originalText = btnText.textContent;

            // 1. Disable tombol & tampilkan spinner
            submitBtn.disabled = true;
            btnText.classList.add('d-none');
            btnSpinner.classList.remove('d-none');

            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch('/future-visitors/visitor-registration', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData,
                });

                const data = await response.json();
                console.log(data);
                if (!data.success) {
                    Object.keys(data.messages).forEach(fieldName => {
                        const inputField = document.getElementById(fieldName);
                        if (inputField) {
                            inputField.classList.add('is-invalid');
                            if (inputField.nextElementSibling) {
                                inputField.nextElementSibling.textContent = data.messages[
                                    fieldName][0];
                            }
                        }
                    });

                    const validFields = document.querySelectorAll('.is-invalid');
                    validFields.forEach(validField => {
                        const fieldName = validField.id;
                        if (!data.messages[fieldName]) {
                            validField.classList.remove('is-invalid');
                            if (validField.nextElementSibling) {
                                validField.nextElementSibling.textContent = '';
                            }
                        }
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Something went wrong!',
                    });

                    return;
                }

                const invalidInputs = document.querySelectorAll('.is-invalid');
                invalidInputs.forEach(invalidInput => {
                    invalidInput.value = '';
                    invalidInput.classList.remove('is-invalid');
                    const errorNextSibling = invalidInput.nextElementSibling;
                    if (errorNextSibling && errorNextSibling.classList.contains(
                            'invalid-feedback')) {
                        errorNextSibling.textContent = '';
                    }
                });

                form.reset();
                toastr.success("Data Berhasil di simpan", "Success");
            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Something went wrong!',
                });
            } finally {
                // 2. Aktifkan kembali tombol & sembunyikan spinner
                submitBtn.disabled = false;
                btnText.classList.remove('d-none');
                btnSpinner.classList.add('d-none');
                btnText.textContent = originalText; // Kembalikan teks tombol ke semula
            }
        });
    </script>

    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets') }}/plugins/global/plugins.bundle.js"></script>
    <script src="{{ asset('assets') }}/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('assets') }}/plugins/custom/fslightbox/fslightbox.bundle.js"></script>
    <script src="{{ asset('assets') }}/plugins/custom/typedjs/typedjs.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('assets') }}/js/custom/landing.js"></script>
    <script src="{{ asset('assets') }}/js/custom/pages/pricing/general.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>

</html>
