@extends('layouts.master')

@section('title')
    Input data pengunjung
@endsection

@push('style')
    <link href="{{ asset('assets') }}/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets') }}/js/scripts.bundle.js"></script>
@endpush

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid gap-10"
                id="kt_create_account_stepper"> --}}
            <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row" id="kt_stepper_example_vertical">
                <div class="card d-flex flex-row-fluid flex-center">
                    <div class="card-header align-items-center py-2 gap-2 gap-md-5">
                        <div class="card-title">
                            <div class="d-flex position-relative my-1">
                                <h2>Masukkan Identitas Tamu</h2>
                            </div>
                        </div>
                    </div>
                    <form class="card-body py-2 w-100 mw-xl-700px px-9" novalidate="novalidate" id="addForm">
                        <div class="current" data-kt-stepper-element="content">
                            <div class="w-100">
                                <div class="pb-10 pb-lg-5 mb-3">
                                    <h2 class="fw-bold d-flex align-items-center text-dark">Pilih Lokasi Tujuan Pengunjung
                                    </h2>
                                </div>
                                <input type="hidden" id="id_user" name="id_user" value="">
                                <div class="fv-row">
                                    <div class="col-12 mb-3">
                                        <div id="block-buttons" class="d-flex flex-column gap-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-kt-stepper-element="content">
                            <div class="w-100">
                                <div class="pb-10 pb-lg-5">
                                    <h2 class="fw-bold text-dark">Identitas Pengunjung</h2>
                                    <div class="text-muted fw-semibold fs-6">Perumahan Graha Lestari Makassar</div>
                                </div>
                                <div class="row mb-5 fv-row">
                                    <div class="col-md-6 fv-row">
                                        <label class="required fs-5 fw-semibold mb-2">Nama</label>
                                        <input type="text" class="form-control" placeholder="" name="name"
                                            id="name" />
                                        <div class="invalid-feedback"> </div>
                                    </div>
                                    <div class="col-md-6 fv-row">
                                        <label class="required fs-5 fw-semibold mb-2">Pengunjung</label>
                                        <select class="form-select" name="visitor_type" id="visitor_type">
                                            <option value="" selected disabled>Pilih Jenis Pengunjung</option>
                                            <option value="tamu">Tamu</option>
                                            <option value="kurir">Kurir</option>
                                            <option value="transportasi_online">Transportasi Online</option>
                                        </select>
                                        <div class="invalid-feedback"> </div>
                                    </div>
                                </div>

                                <div class="row mb-5 fv-row">
                                    <div class="col-md-6 fv-row">
                                        <label class="required fs-5 fw-semibold mb-2">No Telepon</label>
                                        <input type="text" class="form-control" placeholder="" name="phone_number"
                                            id="phone_number" />
                                        <div class="invalid-feedback"> </div>
                                    </div>
                                    <div class="col-md-6 fv-row" style="display: none;" id="list_company">
                                        <label class="required fs-5 fw-semibold mb-2">Pilih Kurir</label>
                                        <select class="form-select" name="company_id" id="company_id">
                                            <option value="" selected disabled>Pilih Jenis Pengunjung</option>
                                            <option value="tamu">Tamu</option>
                                            <option value="kurir">Kurir</option>
                                            <option value="transportasi_online">Transportasi Online</option>
                                        </select>
                                        <div class="invalid-feedback"> </div>
                                    </div>
                                </div>
                                <div class="row mb-5 fv-row">
                                    <div class="col-md-12 fv-row">
                                        <label class="required fs-5 fw-semibold mb-2">Tujuan Kunjungan</label>
                                        <textarea class="form-control" placeholder="Tujuan Kunjungan" name="purpose" id="purpose" style="height: 100px"></textarea>
                                        <div class="invalid-feedback"> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-kt-stepper-element="content">
                            <div class="w-100">
                                <div class="pb-10 pb-lg-12">
                                    <h2 class="fw-bold text-dark">Business Details</h2>
                                    <div class="text-muted fw-semibold fs-6">If you need more info, please check out
                                        <a href="#" class="link-primary fw-bold">Help Page</a>.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-kt-stepper-element="content">
                            <div class="w-100">
                                <div class="pb-10 pb-lg-15">
                                    <h2 class="fw-bold text-dark">Billing Details</h2>
                                    <div class="text-muted fw-semibold fs-6">If you need more info, please check out
                                        <a href="#" class="text-primary fw-bold">Help Page</a>.
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex flex-stack pt-10">
                            <div class="mr-2">
                                <button type="button" class="btn btn-lg btn-light-primary me-3"
                                    data-kt-stepper-action="previous">
                                    <i class="ki-outline ki-arrow-left fs-4 me-1"></i>Back</button>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-lg btn-primary me-3"
                                    data-kt-stepper-action="submit">
                                    <span class="indicator-label">Submit
                                        <i class="ki-outline ki-arrow-right fs-3 ms-2 me-0"></i></span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <button type="button" class="btn btn-lg btn-primary"
                                    data-kt-stepper-action="next">Continue
                                    <i class="ki-outline ki-arrow-right fs-4 ms-1 me-0"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div
                    class="card d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px w-xxl-400px">
                    <div class="card-body px-6 px-lg-10 px-xxl-15 py-20">
                        <div class="stepper-nav">
                            <div class="stepper-item current" data-kt-stepper-element="nav">
                                <div class="stepper-wrapper">
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                        <span class="stepper-number">1</span>
                                    </div>
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">Pilih Lokasi</h3>
                                        <div class="stepper-desc fw-semibold">Pilih lokasi tujuan tamu/pengunjung</div>
                                    </div>
                                </div>
                                <div class="stepper-line h-40px"></div>
                            </div>
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <div class="stepper-wrapper">
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                        <span class="stepper-number">2</span>
                                    </div>
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">Identitas Pengunjung</h3>
                                        <div class="stepper-desc fw-semibold">Masukkan identitas pengunjung/tamu</div>
                                    </div>
                                </div>
                                <div class="stepper-line h-40px"></div>
                            </div>
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <div class="stepper-wrapper">
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                        <span class="stepper-number">3</span>
                                    </div>
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">Foto</h3>
                                        <div class="stepper-desc fw-semibold">Ambil foto pengunjung/tamu</div>
                                    </div>
                                </div>
                                <div class="stepper-line h-40px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Stepper lement
        var element = document.querySelector("#kt_stepper_example_vertical");

        // Initialize Stepper
        var stepper = new KTStepper(element);

        // Handle next step
        stepper.on("kt.stepper.next", function(stepper) {
            stepper.goNext(); // go next step
        });

        // Handle previous step
        stepper.on("kt.stepper.previous", function(stepper) {
            stepper.goPrevious(); // go previous step
        });

        document.getElementById('addForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const id_user = document.getElementById('id_user').value;
            const form = event.target;
            const formData = new FormData(form);
            formData.append('id_user', id_user);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch('/visitors/store', {
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

                // Swal.fire({
                //     icon: 'success',
                //     title: 'Success',
                //     text: data.message,
                // });
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toastr-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "100",
                    "hideDuration": "500",
                    "timeOut": "3000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

                toastr.success("Data Berhasil di simpan", "Success");
            } catch (error) {
                console.error(error);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            grade();
        });

        document.getElementById('visitor_type').addEventListener('change', function() {
            const purpose = document.getElementById('purpose');
            const visitorType = document.getElementById('visitor_type').value;

            if (visitorType === 'tamu') {
                document.getElementById('list_company').style.display = 'none';
                purpose.value = 'Bertamu';
            } else if (visitorType === 'kurir') {
                document.getElementById('list_company').style.display = 'block';
                purpose.value = 'Mengantar Barang';
            } else if (visitorType === 'transportasi_online') {
                document.getElementById('list_company').style.display = 'none';
                purpose.value = 'Transportasi Online';
            }
        });

        function grade() {
            fetch('/address/getAddressesGroupedByBlock')
                .then(response => response.json())
                .then(data => {
                    const selectedButton = document.getElementById('id_user');
                    const container = document.getElementById('block-buttons');
                    container.innerHTML = '';

                    for (const block in data) {
                        if (data.hasOwnProperty(block)) {
                            const blockWrapper = document.createElement('div');
                            const title = document.createElement('div');
                            title.className = 'fw-bold block-title mb-2';
                            title.style.fontSize = '16px';
                            title.innerText = 'Blok ' + block;
                            blockWrapper.appendChild(title);

                            const buttonRow = document.createElement('div');
                            buttonRow.type = 'button';
                            buttonRow.style.display = 'flex';
                            buttonRow.style.flexWrap = 'wrap';
                            buttonRow.style.gap = '10px';

                            data[block].forEach(item => {
                                const button = document.createElement('button');
                                button.className =
                                    'house-button btn btn-primary btn-active-light-success';
                                button.innerText = item.house_number;

                                button.dataset.bsToggle = 'tooltip';
                                button.dataset.bsPlacement = 'top';
                                button.title = item.user_nickname;

                                button.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    document.querySelectorAll('.house-button').forEach(btn => btn
                                        .classList.remove('active'));
                                    button.classList.add('active');
                                    selectedButton.value = item.house_number;
                                });

                                buttonRow.appendChild(button);
                            });

                            blockWrapper.appendChild(buttonRow);
                            container.appendChild(blockWrapper);
                        }
                    }
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                })
                .catch(error => {
                    console.error('Error saat mengambil data:', error);
                });
        }
    </script>
@endpush
