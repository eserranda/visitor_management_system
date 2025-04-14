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
                    <div class="row mb-5">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Nama</label>
                            <input type="hidden" class="form-control" name="edit_id" id="edit_id" />
                            <input type="text" class="form-control" placeholder="Nama" name="name"
                                id="edit_name" />
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-5 fw-semibold mb-2">Nomor Telepon</label>
                            <input type="number" class="form-control" placeholder="Nomor telepon" name="phone_number"
                                id="edit_phone_number" />
                            <div class="invalid-feedback"> </div>

                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-6 fv-row">
                            <div class="form-check">
                                <input class="form-check-input " type="checkbox" value="transportasi_online"
                                    name="type" id="edit_type" />
                                <label class="form-check-label" for="type">
                                    Transportasi Online
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 fv-row">
                            <label class="fs-5 fw-semibold mb-2">Alamat</label>
                            <input type="text" class="form-control" placeholder="Alamat" name="address"
                                id="edit_address" />
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
                const response = await fetch(`/companies/update/${id}`, {
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

                // $('#editModal').modal('hide');
            } catch (error) {
                console.error(error);
            }
        });
    </script>
@endpush
