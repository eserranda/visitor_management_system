<!--begin::Wrapper-->
<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    <!--begin::Sidebar-->
    <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="100px"
        data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
        <!--begin::Logo-->
        <div class="app-sidebar-logo d-none d-lg-flex flex-center pt-10 mb-3" id="kt_app_sidebar_logo">
            <!--begin::Logo image-->
            <a href="/">
                <img alt="Logo" src="{{ asset('assets') }}/media/logos/default-small.svg" class="h-30px" />
            </a>
            <!--end::Logo image-->
        </div>
        <!--end::Logo-->
        <!--begin::sidebar menu-->
        <div class="app-sidebar-menu d-flex flex-center overflow-hidden flex-column-fluid">
            <!--begin::Menu wrapper-->
            <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper d-flex hover-scroll-overlay-y my-5"
                data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu, #kt_app_sidebar" data-kt-scroll-offset="5px">
                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-active-bg menu-title-gray-700 menu-arrow-gray-500 menu-icon-gray-500 menu-bullet-gray-500 menu-state-primary my-auto"
                    id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                    <!--begin:Menu item-->
                    <div class="menu-item py-2">
                        <!--begin:Menu link-->
                        <span class="menu-link menu-center">
                            <span class="menu-icon me-0">
                                <a class="btn btm-sm menu-icon me-0" href="/dashboard" data-kt-menu-overflow="true"
                                    data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                                    <i class="ki-outline ki-category fs-2x"> </i>
                                </a>
                            </span>
                        </span>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->

                    {{-- <div class="menu-item py-2">
                        <!--begin:Menu link-->
                        <span class="menu-link menu-center">
                            <span class="menu-icon me-0">
                                <a class="btn btm-sm menu-icon me-0" href="/visitors" data-kt-menu-overflow="true"
                                    data-bs-toggle="tooltip" data-bs-placement="right" title="Registrasi Tamu">
                                    <i class="ki-outline ki-questionnaire-tablet fs-2x"> </i>
                                </a>
                            </span>
                        </span>
                        <!--end:Menu link-->
                    </div> --}}

                    @if (auth()->check() &&
                            auth()->user()->hasRole(['security', 'super_admin', 'admin']))
                        <div class="menu-item py-2">
                            <span class="menu-link menu-center">
                                <span class="menu-icon me-0">
                                    <a class="btn btm-sm menu-icon me-0" href="/visitors/registrasi"
                                        data-kt-menu-overflow="true" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Registrasi Tamu">
                                        <i class="ki-outline ki-faceid fs-2x"></i>
                                    </a>
                                </span>
                            </span>
                        </div>
                    @endif

                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <span class="menu-icon me-0">
                                @if (auth()->check() &&
                                        auth()->user()->hasRole(['security', 'super_admin', 'admin']))
                                    <a class="btn btm-sm menu-icon me-0" href="/future-visitors"
                                        data-kt-menu-overflow="true" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Verifikasi Tamu">
                                        <i class="ki-duotone ki-check fs-2x"></i>
                                    </a>
                                @elseif (auth()->check() &&
                                        auth()->user()->hasRole(['penghuni', 'super_admin']))
                                    <a class="btn btm-sm menu-icon me-0" href="/future-visitors"
                                        data-kt-menu-overflow="true" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Akses Masuk">
                                        <i class="ki-duotone ki-check fs-2x"></i>
                                    </a>
                                @endif
                            </span>
                        </span>
                    </div>

                    @if (auth()->check() &&
                            auth()->user()->hasRole(['security', 'super_admin', 'admin']))
                        <div class="menu-item py-2">
                            <span class="menu-link menu-center">
                                <span class="menu-icon me-0">
                                    <a class="btn btm-sm menu-icon me-0" href="/visitors/pengunjung_aktif"
                                        data-kt-menu-overflow="true" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Monitoring">
                                        <i class="ki-outline ki-eye fs-2x"> </i>
                                    </a>
                                </span>
                            </span>
                        </div>
                    @endif

                    @if (auth()->check() &&
                            auth()->user()->hasRole(['super_admin', 'admin']))
                        <!--begin:Menu item-->
                        <div class="menu-item py-2">
                            <!--begin:Menu link-->
                            <span class="menu-link menu-center">
                                <span class="menu-icon me-0">
                                    <a class="btn btm-sm menu-icon me-0" href="/users" data-kt-menu-overflow="true"
                                        data-bs-toggle="tooltip" data-bs-placement="right" title="Users">
                                        <i class="ki-outline ki-people fs-2x"> </i>
                                    </a>
                                </span>
                            </span>
                            <!--end:Menu link-->
                        </div>
                    @endif



                    @if (auth()->check() &&
                            auth()->user()->hasRole(['super_admin', 'admin']))
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                            class="menu-item py-2">
                            <!--begin:Menu link-->
                            <span class="menu-link menu-center">
                                <span class="menu-icon me-0">
                                    <i class="ki-outline ki-setting-2 fs-2x"> </i>
                                </span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto">
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu content-->
                                    <div class="menu-content">
                                        <span class="menu-section fs-5 fw-bolder ps-1 py-1">Pengaturan</span>
                                    </div>
                                    <!--end:Menu content-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="/address">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Alamat Rumah</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="/companies">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Kurir/Trasportasi Online</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="/roles">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Role Users</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->

                            </div>
                            <!--end:Menu sub-->
                        </div>
                    @endif
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Menu wrapper-->
        </div>
        <!--end::sidebar menu-->
        <!--begin::Footer-->
        <div class="app-sidebar-footer d-flex flex-center flex-column-auto pt-6 mb-7" id="kt_app_sidebar_footer">
            <!--begin::Menu-->
            <div class="mb-0">
                <!--begin:Menu item-->
                <div class="menu-item py-2">
                    <!--begin:Menu link-->
                    <span class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <a class="btn btm-sm menu-icon me-0" href="/auth/logout" data-kt-menu-overflow="true"
                                data-bs-toggle="tooltip" data-bs-placement="right" title="Logout">
                                <i class="ki-outline ki-exit-left fs-1"></i>
                            </a>
                        </span>
                    </span>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                {{-- <button type="button" class="btn btm-sm btn-custom btn-icon" data-kt-menu-trigger="click"
                    data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-bs-toggle="tooltip"
                    data-bs-placement="right" data-bs-dismiss="click" title="Quick actions">
                    <i class="ki-outline ki-notification-status fs-1"></i>
                </button>
                <!--begin::Menu 2-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                    data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick Actions</div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator mb-3 opacity-75"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">New Ticket</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">New Customer</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                        <!--begin::Menu item-->
                        <a href="#" class="menu-link px-3">
                            <span class="menu-title">New Group</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <!--end::Menu item-->
                        <!--begin::Menu sub-->
                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">Admin Group</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">Staff Group</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">Member Group</a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu sub-->
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">New Contact</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator mt-3 opacity-75"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content px-3 py-3">
                            <a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
                        </div>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu 2--> --}}
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Footer-->
    </div>
    <!--end::Sidebar-->
