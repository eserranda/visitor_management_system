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
    <div class="d-flex flex-column ">
        <div class="mt-10 position-relative z-index-2">
            <!--begin::Container-->
            <div class="container col-lg-3 col-md-3">
                <!--begin::Heading-->
                {{--  
                @php
                    $status = isset($status) ? $status : false;
                    $id_visitor = isset($id_visitor) ? $id_visitor : null;
                @endphp --}}
                @if ($status == true)
                    <div class="text-center mb-7">
                        <h3 class="fs-2hx text-dark mb-5">
                            Verifikasi Tamu
                        </h3>
                        <div class="fs-5 text-muted fw-bold">
                            Silahkan melakuan verifikasi data tamu
                        </div>
                    </div>
                    <div class="card-rounded shadow p-8 p-lg-12 mb-n5 mb-lg-n13"
                        style="background: linear-gradient(90deg, #287ec5 0%, #03A588 100%);">
                        <div class="my-2 d-flex justify-content-center gap-20">
                            <button type="submit" class="btn btn-success px-6" onclick="verify(1)">Verifikasi</button>
                            <button type="button" class="btn btn-danger px-6" onclick="verify(0)">Tolak</button>
                        </div>
                    </div>
                @else
                    <div class="card-rounded shadow p-8 p-lg-12 mb-n5 mb-lg-n13 border border-danger">
                        <h3 class="fs-2hx text-dark mb-5 align-items-center text-center">
                            Mohon Maaf
                        </h3>
                        <div class="fs-5 text-muted fw-bold align-items-center text-center">
                            Tamu ini tidak terdaftar sebagai tamu anda
                        </div>
                        <div class="my-2 d-flex justify-content-center gap-15">
                            <a href="{{ url('/dashboard') }}" class="btn btn-success px-6 mt-3">Dashboard</a>
                            <a href="#" class="btn btn-secondary px-6 mt-3" id="reload">Reload</a>
                        </div>
                    </div>
                @endif
            </div>
            <!--end::Container-->
        </div>
    </div>


    <script>
        document.getElementById('reload').addEventListener('click', function() {
            location.reload();
        });

        async function verify(status) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            try {
                const response = await fetch('/future-visitors/visitor-verification/' + '{{ $id_visitor }}', {
                    method: 'PUT',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        status: status
                    }),
                });

                const data = await response.json();
                console.log(data);
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Tamu berhasil diverifikasi!',
                    });
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

        // document.getElementById('addForm').addEventListener('submit', async (event) => {
        //     event.preventDefault();

        //     const form = event.target;
        //     const formData = new FormData(form);

        //     const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        //     try {
        //         const response = await fetch('/future-visitors/visitor-registration', {
        //             method: 'POST',
        //             headers: {
        //                 'Accept': 'application/json',
        //                 'X-CSRF-TOKEN': csrfToken
        //             },
        //             body: formData,
        //         });

        //         const data = await response.json();
        //         console.log(data);
        //         if (!data.success) {
        //             Object.keys(data.messages).forEach(fieldName => {
        //                 const inputField = document.getElementById(fieldName);
        //                 if (inputField) {
        //                     inputField.classList.add('is-invalid');
        //                     if (inputField.nextElementSibling) {
        //                         inputField.nextElementSibling.textContent = data.messages[
        //                             fieldName][0];
        //                     }
        //                 }
        //             });

        //             const validFields = document.querySelectorAll('.is-invalid');
        //             validFields.forEach(validField => {
        //                 const fieldName = validField.id;
        //                 if (!data.messages[fieldName]) {
        //                     validField.classList.remove('is-invalid');
        //                     if (validField.nextElementSibling) {
        //                         validField.nextElementSibling.textContent = '';
        //                     }
        //                 }
        //             });

        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Gagal',
        //                 text: 'Something went wrong!',
        //             });

        //             return;
        //         }

        //         const invalidInputs = document.querySelectorAll('.is-invalid');
        //         invalidInputs.forEach(invalidInput => {
        //             invalidInput.value = '';
        //             invalidInput.classList.remove('is-invalid');
        //             const errorNextSibling = invalidInput.nextElementSibling;
        //             if (errorNextSibling && errorNextSibling.classList.contains(
        //                     'invalid-feedback')) {
        //                 errorNextSibling.textContent = '';
        //             }
        //         });

        //         // form.reset();
        //         toastr.success("Data Berhasil di simpan", "Success");
        //     } catch (error) {
        //         console.error(error);
        //     }
        // });
    </script>

    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets') }}/plugins/global/plugins.bundle.js"></script>
    <script src="{{ asset('assets') }}/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
</body>

</html>
