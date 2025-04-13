@extends('layouts.master')

@section('title')
    Add Data Users
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="col-lg-12">
            <div class="card">
                <div class="col-md-12">
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <div class="card-title d-flex align-items-center">
                            <h3 class="fw-bold m-0 text-gray-800">Input Data Users</h3>
                        </div>
                    </div>
                    <form id="addForm">
                        <div class="card-body">
                            <div class="row g-9 mb-4">
                                <div class="col-md-4 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Nama Lengkap</label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Nama Lengkap"
                                        name="name" id="name" />
                                    <div class="invalid-feedback"> </div>
                                </div>
                                <div class="col-md-4 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Username</label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Username"
                                        name="username" id="username" />
                                    <div class="invalid-feedback"> </div>
                                </div>
                                <div class="col-md-4 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Nama Panggilan</label>
                                    <input type="text" class="form-control form-control-solid"
                                        placeholder="Contoh : Bapak Juni" name="nickname" id="nickname" />
                                    <div class="invalid-feedback"> </div>
                                </div>
                            </div>

                            <div class="row g-9 mb-4">
                                <div class="col-md-4 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Email</label>
                                    <input type="mail" class="form-control form-control-solid" placeholder="Email"
                                        name="email" id="email" value="example@gmail.com" />
                                    <div class="invalid-feedback"> </div>
                                </div>
                                <div class="col-md-4 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Password</label>
                                    <input type="password" class="form-control form-control-solid" placeholder="********"
                                        name="password" id="password" />
                                    <div class="invalid-feedback"> </div>
                                </div>
                                <div class="col-md-4 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Ulangi Password</label>
                                    <input type="password" class="form-control form-control-solid" placeholder="********"
                                        name="password_confirmation" id="password_confirmation" />
                                    <div class="invalid-feedback"> </div>
                                </div>
                            </div>

                            <div class="row g-9 mb-4">
                                <div class="col-md-4 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Nomor HP.</label>
                                    <input type="number" class="form-control form-control-solid" placeholder="Phone Number"
                                        name="phone_number" id="phone_number" />
                                    <div class="invalid-feedback"> </div>
                                </div>
                                <div class="col-md-4 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Role</label>
                                    <select class="form-select form-select-solid" data-hide-search="true"
                                        data-placeholder="Pilih Role" name="roles[]" id="roles">
                                        <option value="" selected disabled>Pilih Role</option>
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"> </div>
                                </div>
                                <div class="col-md-4 fv-row">
                                    <label class="fs-5 fw-semibold mb-2">Keterangan</label>
                                    <input type="tetx" class="form-control form-control-solid" placeholder="Keterangan"
                                        name="keterangan" id="keterangan" />
                                    <div class="invalid-feedback"> </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="/users" class="btn btn-warning mx-2">Kembali</a>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('addForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch('/users/register', {
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

                Swal.fire({
                    title: 'Success!',
                    text: "Data berhasil di tambahkan!",
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Tambah Lagi',
                    confirmButtonColor: '#3085d6',

                    cancelButtonText: 'Lihat Data',
                    cancelButtonColor: '#28a745',
                    allowOutsideClick: false,
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.reset();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        window.location.href = '/users';
                    }
                })
            } catch (error) {
                console.error(error);
            }
        });
    </script>
@endpush
