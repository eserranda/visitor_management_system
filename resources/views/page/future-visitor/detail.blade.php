<div class="modal fade" tabindex="1" id="detailModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detail Data</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row mb-7">
                            <label class="col-lg-6 fw-semibold text-muted px-7">Nama Tamu</label>
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_visitor_name"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-6 fw-semibold text-muted px-7">Tujuan</label>
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_user_id"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-6 fw-semibold text-muted px-7">Blok</label>
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_address"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-6 fw-semibold text-muted px-7">Tanggal</label>
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_arrival_date"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-6 fw-semibold text-muted px-7">Estimasi Jam Kedatangan</label>
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_estimated_arrival_time"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-6 fw-semibold text-muted px-7">Jenis Kendaraan</label>
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_vehicle_type"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-6 fw-semibold text-muted px-7">Nomor Plat</label>
                            <div class="col-lg-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_vehicle_number"></span>
                            </div>
                        </div>
                        {{-- <div class="row mb-7">
                            <label class="col-lg-4 fw-semibold text-muted px-7">Jenis Pengunjung</label>
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_visitor_type"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-semibold text-muted px-7">Jam Masuk</label>
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_check_in"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-semibold text-muted px-7">Jam Keluar</label>
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_check_out"></span>
                            </div>
                        </div> --}}

                        <div class="row mb-7">
                            <label class="col-lg-4 fw-semibold text-muted px-7">Status</label>
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_status"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>



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
                $('#detailModal').modal('hide');
                // document.querySelector('[data-bs-dismiss="modal"]').click();
                $('#datatable').DataTable().ajax.reload();

                // $('#detailModal').modal('hide');
            } catch (error) {
                console.error(error);
            }
        });
    </script>
@endpush
