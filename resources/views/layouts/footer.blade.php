<!--begin::Footer-->
<div id="kt_app_footer" class="app-footer">
    <!--begin::Footer container-->
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2025&copy;</span>
            <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Visitor Management
                System</a>
        </div>
        <!--end::Copyright-->
        <!--begin::Menu-->
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            <li class="menu-item">
                <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
            </li>
            <li class="menu-item">
                <a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
            </li>
            <li class="menu-item">
                <a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
            </li>
        </ul>
        <!--end::Menu-->
    </div>
    <!--end::Footer container-->
</div>
<!--end::Footer-->
</div>
<!--end:::Main-->
</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>
<!--end::App-->

<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-outline ki-arrow-up"></i>
</div>
<!--end::Scrolltop-->

<!--begin::Modals-->
<div class="modal fade" tabindex="1" id="messageModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">

            <form id="messageForm">
                <div class="modal-body">
                    <div class="col-md-12 ">
                        <label class="fs-5 fw-semibold mb-4">Tinggalkan Pesan</label>
                        <textarea class="form-control" placeholder="Tinggalkan pesan" name="information" id="information"></textarea>
                        <div class="invalid-feedback"> </div>

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

<script>
    document.getElementById('messageForm').addEventListener('submit', async (event) => {
        event.preventDefault();

        const switchElement = document.getElementById('notificationSwitch');
        const statusText = document.getElementById('statusText');

        // simpan status ke localStorage
        const form = event.target;
        const formData = new FormData(form);
        // tamabhak status
        formData.append('status', 'out_house');

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        try {
            const response = await fetch('/users/update-status', {
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
            toastr.success("Status Berhasil diperbaharui", "Success");
            document.querySelector('[data-bs-dismiss="modal"]').click();

        } catch (error) {
            console.error(error);
            toastr.error("Status gagal diperbaharui", "Error");
        }
    });
</script>

<!--end::Modals-->

<!--begin::Javascript-->
<script>
    var hostUrl = "{{ asset('assets') }}";
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('assets') }}/plugins/global/plugins.bundle.js"></script>
<script src="{{ asset('assets') }}/js/scripts.bundle.js"></script>
<script src="{{ asset('assets') }}/plugins/global/plugins.bundle.js"></script>

<!--end::Global Javascript Bundle-->

@stack('scripts')
</body>
<!--end::Body-->

</html>
