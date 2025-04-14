<div class="modal fade" tabindex="1" id="editModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Data</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>


            <form id="editForm">
                <div class="modal-body">
                    <div class="row g-9 mb-4">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Nama Lengkap</label>
                            <input type="hidden" class="form-control" name="edit_id" id="edit_id" />
                            <input type="text" class="form-control" placeholder="Nama Lengkap" name="edit_name"
                                id="edit_name" />
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Username</label>
                            <input type="text" class="form-control" placeholder="Username" name="edit_username"
                                id="edit_username" />
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Nama Panggilan</label>
                            <input type="text" class="form-control" placeholder="Contoh : Bapak Juni"
                                name="edit_nickname" id="edit_nickname" />
                            <div class="invalid-feedback"> </div>
                        </div>
                    </div>

                    <div class="row g-9 mb-4">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Email</label>
                            <input type="mail" class="form-control" placeholder="Email" name="edit_email"
                                id="edit_email" value="example@gmail.com" />
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Password</label>
                            <input type="password" class="form-control" placeholder="********" name="password"
                                id="password" readonly disabled />
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Ulangi Password</label>
                            <input type="password" class="form-control" placeholder="********"
                                name="password_confirmation" id="password_confirmation" readonly disabled />
                            <div class="invalid-feedback"> </div>
                        </div>
                    </div>

                    <div class="row g-9 mb-4">
                        <div class="col-md-4 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Nomor HP.</label>
                            <input type="number" class="form-control" placeholder="Phone Number"
                                name="edit_phone_number" id="edit_phone_number" />
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Role</label>
                            <select class="form-select" data-hide-search="true" data-placeholder="Pilih Role"
                                name="edit_roles[]" id="edit_roles">
                                <option value="" selected disabled>Pilih Role</option>
                                {{-- @foreach ($roles as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach --}}
                            </select>
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="fs-5 fw-semibold mb-2">Keterangan</label>
                            <input type="tetx" class="form-control" placeholder="Keterangan" name="keterangan"
                                id="keterangan" />
                            <div class="invalid-feedback"> </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.getElementById('editForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const id = document.getElementById('edit_id').value;
                const response = await fetch(`/users/update/${id}`, {
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
                        const inputField = document.getElementById('edit_' + fieldName);
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
                        const fieldName = validField.id.replace('edit_', '');
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
                $('#editModal').modal('hide');
                // document.querySelector('[data-bs-dismiss="modal"]').click();
                $('#datatable').DataTable().ajax.reload();
            } catch (error) {
                console.error(error);
            }
        });
    </script>
@endpush
