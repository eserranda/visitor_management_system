<div class="modal fade" tabindex="1" id="addModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah data</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <form id="addForm">
                <div class="modal-body">
                    <div class="row mb-5">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Nama Tamu</label>
                            <input type="text" class="form-control" placeholder="Nama Tamu" name="visitor_name"
                                id="visitor_name" />
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Tanggal</label>
                            <input type="date" class="form-control" placeholder="Tanggal" name="arrival_date"
                                id="arrival_date" />
                            <div class="invalid-feedback"> </div>

                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Jam (Estimasi waktu kedatangan)</label>
                            <input type="time" class="form-control" placeholder="estimated_arrival_time"
                                name="estimated_arrival_time" id="purpose" />
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-5 fw-semibold mb-2">Jenis Kendaraan</label>
                            <select class="form-select" name="vehicle_type" id="vehicle_type">
                                <option selected disabled>- Pilih jenis kendaraan -</option>
                                <option value="Mobil">Mobil</option>
                                <option value="Motor">Motor</option>
                                <div class="invalid-feedback"> </div>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-6 fv-row">
                            <label class="fs-5 fw-semibold mb-2">Nomor Plat Kendaraan</label>
                            <input type="text" class="form-control" placeholder="Plat kendaraan"
                                name="vehicle_number" id="vehicle_number" />
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-5 fw-semibold mb-2">Foto Tamu</label>
                            <input type="file" class="form-control" name="captured_image" id="captured_image" />
                            <div class="invalid-feedback"> </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.getElementById('addForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch('/future-visitors/store', {
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
                // $('#addModal').modal('hide');
                document.querySelector('[data-bs-dismiss="modal"]').click();
                $('#datatable').DataTable().ajax.reload();

            } catch (error) {
                console.error(error);
            }
        });
    </script>
@endpush
