<div class="modal fade" tabindex="-1" id="detailModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detail Pengunjung</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <h5 class="card-title text-center py-5">Foto Tamu</h5>
                            <div class="card-body">
                                <!-- Content for the first card -->
                                <div class="symbol symbol-200px symbol-lg-200px">
                                    <img src="" alt="image" class="rounded-circle" id="image_show" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card  ">
                            <h5 class="card-title text-center py-5">Data Tamu</h5>
                            <div class="card-body p-5">
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted px-7">Nama</label>
                                    <input type="hidden" class="form-control" name="detail_id" id="detail_id" />
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800" id="detail_visitor_name"></span>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted px-7">Tgl Kedatangan</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800" id="detail_arrival_date"></span>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted px-7">Estimasi Kedatangan</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800"
                                            id="detail_estimated_arrival_time"></span>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted px-7">Jenis Kendaraan</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800" id="detail_vehicle_type"></span>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted px-7">Nomor Plat</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800" id="detail_vehicle_number"></span>
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
                                </div>

                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted px-7">Status Verifikasi Pemilik
                                        Rumah</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800" id="detail_verify_status"></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (auth()->check() &&
                    auth()->user()->hasRole(['security', 'super_admin', 'admin']))
                <div class="d-flex flex-column align-items-center mb-7">
                    <h4 class="mb-3">Apakah Data Sudah Sesuai?</h4>
                    <div class="d-flex gap-15">

                        <button type="button" id="updateButton" class="btn btn-success" onclick="update()">YA</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                    </div>
                </div>
            @endif
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div> --}}

        </div>
    </div>
</div>



{{-- <div class="modal fade" tabindex="1" id="detailModal" role="dialog" aria-hidden="true">
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
                    <div class="col-12 col-md-8">
                        <div class="row mb-7">
                            <label class="col-6 fw-semibold text-muted px-7">Nama Tamu</label>
                            <div class="col-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_visitor_name"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-6 fw-semibold text-muted px-7">Tujuan</label>
                            <div class="col-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_user_id"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-6 fw-semibold text-muted px-7">Alamat Tujuan</label>
                            <div class="col-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_address"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-6 fw-semibold text-muted px-7">Tanggal</label>
                            <div class="col-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_arrival_date"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-6 fw-semibold text-muted px-7">Estimasi Jam Kedatangan</label>
                            <div class="col-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_estimated_arrival_time"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-6 fw-semibold text-muted px-7">Jenis Kendaraan</label>
                            <div class="col-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_vehicle_type"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-6 fw-semibold text-muted px-7">Nomor Plat</label>
                            <div class="col-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_vehicle_number"></span>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <label class="col-6 fw-semibold text-muted px-7">Status</label>
                            <div class="col-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_status"></span>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <label class="col-6 fw-semibold text-muted px-7">Check In</label>
                            <div class="col-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_check_in"></span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-6 fw-semibold text-muted px-7">Check Out</label>
                            <div class="col-6">
                                <span class="fw-bold fs-6 text-gray-800" id="detail_check_out"></span>
                            </div>
                        </div>
                    </div>
                </div>

                @if (auth()->check() &&
    auth()->user()->hasRole(['security', 'super_admin', 'admin']))
                    <div class="d-flex flex-column align-items-center mb-7">
                        <h4 class="mb-3">Apakah Data Sudah Sesuai?</h4>
                        <div class="d-flex gap-15">

                            <button type="button" id="updateButton" class="btn btn-success"
                                onclick="update()">YA</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div> --}}

@push('scripts')
    <script>
        async function update() {
            const id = document.getElementById('detail_id').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            try {
                const response = await fetch(`/future-visitors/update-status/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        status: 'approved'
                    })
                });

                const data = await response.json();
                if (response.ok) {
                    toastr.success("Data Berhasil di update", "Success");
                    $('#detailModal').modal('hide');
                    $('#datatable').DataTable().ajax.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Something went wrong!',
                    });
                }
            } catch (error) {
                console.error(error);
            }

        }
    </script>
@endpush
