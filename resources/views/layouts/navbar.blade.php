<!--begin::Page title wrapper-->
<div id="kt_app_header_page_title_wrapper">
    <!--begin::Page title-->
    <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_page_title_wrapper'}"
        class="page-title d-flex flex-column justify-content-center me-3 mb-6 mb-lg-0">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center me-3 my-0">
            @yield('title')
        </h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="/" class="text-muted text-hover-primary">Home</a>
            </li>
            <!--end::Item-->
            @php
                $segments = request()->segments();
            @endphp
            <!--begin::Item-->
            @if (request()->path() != '/')
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <li class="breadcrumb-item text-muted">{{ ucfirst($segments[0]) }}</li>
            @endif
            <!--end::Item-->

            <!--begin::Item-->

            @if (count($segments) > 1)
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <li class="breadcrumb-item text-muted">{{ ucfirst($segments[1]) }}</li>
            @endif
            <!--end::Item-->

        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
</div>
<!--end::Page title wrapper-->
<!--begin::Navbar-->
<div class="app-navbar flex-stack flex-shrink-0" id="kt_app_aside_navbar">
    <!--begin:Author-->
    <div class="d-flex align-items-center me-5 me-lg-10">
        <!--begin::User menu-->
        <div class="app-navbar-item me-4" id="kt_header_user_menu_toggle">
            <!--begin::Menu wrapper-->
            <div class="cursor-pointer symbol symbol-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-attach="parent" data-kt-menu-placement="bottom-start">
                <img src="{{ asset('assets') }}/media/avatars/300-1.jpg" alt="user" />
            </div>
            <!--begin::User account menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                data-kt-menu="true">
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <div class="menu-content d-flex align-items-center px-3">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-50px me-5">
                            <img alt="Logo" src="{{ asset('assets') }}/media/avatars/300-1.jpg" />
                        </div>
                        <!--end::Avatar-->
                        <!--begin::Username-->
                        <div class="d-flex flex-column">
                            <div class="fw-bold d-flex align-items-center fs-5">
                                {{ auth()->check() ? auth()->user()->name : '' }}
                                {{-- <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span> --}}
                            </div>
                            <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                                {{ auth()->check() ? auth()->user()->email : '' }}
                            </a>
                        </div>
                        <!--end::Username-->
                    </div>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu separator-->
                <div class="separator my-2"></div>
                <!--end::Menu separator-->
                <!--begin::Menu item-->

                <div class="menu-item px-5">
                    <span class="menu-link px-5">Status</span>
                </div>


                <div class="menu-item px-5">
                    <div class="menu-content px-5">
                        <label class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input w-30px h-20px" type="checkbox" value="0"
                                checked="checked" name="notifications" id="notificationSwitch" />
                            <span class="form-check-label text-muted fs-7" id="statusText">Loading...</span>
                        </label>
                    </div>
                </div>

                <script>
                    // load dom element
                    document.addEventListener('DOMContentLoaded', function() {
                        const switchElement = document.getElementById('notificationSwitch');
                        const statusText = document.getElementById('statusText');

                        // Ambil status user dari backend
                        @if (auth()->check())
                            const statusUser = "{{ auth()->user()->status }}";
                        @else
                            const statusUser = "";
                        @endif

                        if (statusUser === 'in_house') {
                            switchElement.checked = true;
                            statusText.textContent = 'Berada Di Rumah';
                        } else {
                            switchElement.checked = false;
                            statusText.textContent = 'Berada Di Luar';
                        }

                        // munculkan alert saat switch diubah
                        switchElement.addEventListener('change', function() {
                            if (!this.checked) {
                                switchElement.checked = false;
                                statusText.textContent = 'Berada Di Luar';

                                $('#messageModal').modal('show');
                            } else {
                                localStorage.setItem('notificationStatus', 'in_house');
                                statusText.textContent = 'Berada Di Rumah';

                                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                                try {
                                    fetch('/users/update-status', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'Accept': 'application/json',
                                                'X-CSRF-TOKEN': csrfToken
                                            },
                                            body: JSON.stringify({
                                                status: 'in_house'
                                            }),
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            console.log(data);
                                            if (data.success) {
                                                toastr.success("Status Berhasil diperbaharui", "Success");
                                            } else {
                                                toastr.error("Status gagal diperbaharui", "Error");
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            toastr.error("Status gagal diperbaharui", "Error");
                                        });
                                } catch (error) {
                                    console.error('Error:', error);
                                }
                            }
                        });
                    });
                </script>

                <div class="separator my-2"></div>
                <!--end::Menu separator-->
                <!--begin::Menu item-->
                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                    data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                    <a href="#" class="menu-link px-5">
                        <span class="menu-title position-relative">Mode
                            <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
                                <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
                            </span></span>
                    </a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                        data-kt-menu="true" data-kt-element="theme-mode-menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-outline ki-night-day fs-2"></i>
                                </span>
                                <span class="menu-title">Light</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-outline ki-moon fs-2"></i>
                                </span>
                                <span class="menu-title">Dark</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-outline ki-screen fs-2"></i>
                                </span>
                                <span class="menu-title">System</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                {{-- <div class="menu-item px-5 my-1">
                    <a href="../../demo25/dist/account/settings.html" class="menu-link px-5">Account Settings</a>
                </div> --}}
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-5">
                    <a href="/auth/logout" class="menu-link px-5">Logout</a>
                </div>
                <!--end::Menu item-->
            </div>
            <!--end::User account menu-->
            <!--end::Menu wrapper-->
        </div>
        <!--end::User menu-->
        <!--begin:Info-->
        <div class="d-flex flex-column">
            <a href="../../demo25/dist/pages/user-profile/overview.html"
                class="app-navbar-user-name text-gray-900 text-hover-primary fs-5 fw-bold">
                {{ auth()->check() ? auth()->user()->name : '' }}
            </a>
            @foreach (auth()->check() ? auth()->user()->roles : [] as $role)
                <span class="app-navbar-user-info text-gray-600 fw-semibold fs-7">
                    {{ $role->name }}
                </span>
            @endforeach
        </div>
        <!--end:Info-->
    </div>
    <!--end:Author-->
    <!--begin::Quick links-->
    <div class="app-navbar-item">
        <!--begin::Menu wrapper-->
        <div class="btn btn-icon btn-custom btn-dark w-40px h-40px app-navbar-user-btn"
            data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
            data-kt-menu-placement="bottom-end">
            <i class="ki-outline ki-notification-on fs-1"></i>
        </div>
        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-325px" data-kt-menu="true">
            <!--begin::Heading-->
            <div class="d-flex flex-column flex-center bgi-no-repeat rounded-top px-9 py-5"
                style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
                <!--begin::Title-->
                <h3 class="text-dark fw-semibold mb-3">Quick Links</h3>
                <!--end::Title-->
                <!--begin::Status-->
                {{-- <span class="badge bg-primary text-inverse-primary py-2 px-3">25 pending
                    tasks</span> --}}
                <!--end::Status-->
            </div>
            <!--end::Heading-->
            <!--begin:Nav-->
            <div class="row g-0">
                <!--begin:Item-->
                <div class="col-6">
                    <a href="../../demo25/dist/apps/projects/budget.html"
                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                        <i class="ki-outline ki-dollar fs-3x text-primary mb-2"></i>
                        <span class="fs-5 fw-semibold text-gray-800 mb-0">Accounting</span>
                        <span class="fs-7 text-gray-400">eCommerce</span>
                    </a>
                </div>
                <!--end:Item-->
                <!--begin:Item-->
                <div class="col-6">
                    <a href="../../demo25/dist/apps/projects/settings.html"
                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-bottom">
                        <i class="ki-outline ki-sms fs-3x text-primary mb-2"></i>
                        <span class="fs-5 fw-semibold text-gray-800 mb-0">Administration</span>
                        <span class="fs-7 text-gray-400">Console</span>
                    </a>
                </div>
                <!--end:Item-->
                <!--begin:Item-->
                <div class="col-6">
                    <a href="../../demo25/dist/apps/projects/list.html"
                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end">
                        <i class="ki-outline ki-abstract-41 fs-3x text-primary mb-2"></i>
                        <span class="fs-5 fw-semibold text-gray-800 mb-0">Projects</span>
                        <span class="fs-7 text-gray-400">Pending Tasks</span>
                    </a>
                </div>
                <!--end:Item-->
                <!--begin:Item-->
                <div class="col-6">
                    <a href="../../demo25/dist/apps/projects/users.html"
                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light">
                        <i class="ki-outline ki-briefcase fs-3x text-primary mb-2"></i>
                        <span class="fs-5 fw-semibold text-gray-800 mb-0">Customers</span>
                        <span class="fs-7 text-gray-400">Latest cases</span>
                    </a>
                </div>
                <!--end:Item-->
            </div>
            <!--end:Nav-->
            <!--begin::View more-->
            {{-- <div class="py-2 text-center border-top">
                <a href="../../demo25/dist/pages/user-profile/activity.html"
                    class="btn btn-color-gray-600 btn-active-color-primary">View All
                    <i class="ki-outline ki-arrow-right fs-5"></i></a>
            </div> --}}
            <!--end::View more-->
        </div>
        <!--end::Menu-->
        <!--end::Menu wrapper-->
    </div>
    <!--end::Quick links-->
</div>
<!--end::Navbar-->
</div>
<!--end::Header wrapper-->
</div>
<!--end::Header container-->
</div>
<!--end::Header-->
