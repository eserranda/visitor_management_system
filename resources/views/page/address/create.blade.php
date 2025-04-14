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
                        <div class="col-md-12 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Pilih Users</label>
                            <select class="form-select" data-control="select2" data-placeholder="Pilih users"
                                name="user_id" id="user_id">
                                <option></option>
                                {{-- @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach --}}
                            </select>
                            <div class="invalid-feedback"> </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Pilih Blok</label>
                            <select class="form-select" data-control="select2" data-placeholder="Pilih blok"
                                name="block_number" id="block_number">
                                <option></option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                                <option value="H">H</option>
                                <option value="I">I</option>
                                <option value="J">J</option>
                                <option value="K">K</option>
                                <option value="L">L</option>
                                <option value="M">M</option>
                                <option value="N">N</option>
                                <option value="O">O</option>
                                <option value="P">P</option>
                                <option value="Q">Q</option>
                                <option value="R">R</option>
                                <option value="S">S</option>
                                <option value="T">T</option>
                                <option value="U">U</option>
                                <option value="V">V</option>
                                <option value="W">W</option>
                                <option value="X">X</option>
                                <option value="Y">Y</option>
                                <option value="Z">Z</option>
                            </select>
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">Nomor Rumah</label>
                            <input type="Number" class="form-control" placeholder="" name="house_number"
                                id="house_number" />
                            <div class="invalid-feedback"> </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 fv-row">
                            <label class="fs-5 fw-semibold mb-2">Nama Jalan</label>
                            <textarea class="form-control" placeholder="Nama jalan" name="street_name" id="street_name" style="height: 100px"></textarea>
                            <div class="invalid-feedback"> </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="/address" class="btn btn-warning mx-2">Kembali</a>

                    <button type="submit" class="btn btn-primary">Simpan</button>
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
                const response = await fetch('/address/store', {
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
                        if (fieldName === 'block_number' || fieldName === 'user_id') {
                            // Menangani elemen Select2
                            inputField.classList.add('is-invalid');

                            // Tambahan: style container Select2 untuk menunjukkan error
                            const select2Container = $(inputField).next('.select2-container');
                            if (select2Container.length) {
                                select2Container.find('.select2-selection').addClass('border-danger');
                            }

                            // Perbarui pesan error
                            if (inputField.nextElementSibling && inputField.nextElementSibling.classList
                                .contains('invalid-feedback')) {
                                inputField.nextElementSibling.textContent = data.messages[fieldName][0];
                            }
                        } else {
                            inputField.classList.add('is-invalid');
                            if (inputField.nextElementSibling) {
                                inputField.nextElementSibling.textContent = data.messages[fieldName][0];
                            }
                        }
                    });

                    // Hapus validasi dari field yang valid
                    const validFields = document.querySelectorAll('.is-invalid');
                    validFields.forEach(validField => {
                        const fieldName = validField.id;
                        if (!data.messages[fieldName]) {
                            validField.classList.remove('is-invalid');

                            // Juga hapus style error dari container Select2
                            if (validField.getAttribute('data-control') === 'select2') {
                                const select2Container = $(validField).next('.select2-container');
                                if (select2Container.length) {
                                    select2Container.find('.select2-selection').removeClass(
                                        'border-danger');
                                }
                            }

                            if (validField.nextElementSibling && validField.nextElementSibling.classList
                                .contains('invalid-feedback')) {
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
                $('#addModal').modal('hide');
                // document.querySelector('[data-bs-dismiss="modal"]').click();
                $('#datatable').DataTable().ajax.reload();
            } catch (error) {
                console.error(error);
            }
        });
    </script>
@endpush
