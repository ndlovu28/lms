<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<header class="header-area bg-white mb-4 rounded-10 border border-white" id="header-area">
    <div class="row align-items-center">
        <div class="col-md-6">
            {{--
            <div class="left-header-content">
                <ul class="d-flex align-items-center ps-0 mb-0 list-unstyled justify-content-center justify-content-md-start">
                    <li class="d-xl-none">
                        <button class="header-burger-menu bg-transparent p-0 border-0 position-relative top-3" id="header-burger-menu">
                            <span class="border-1 d-block for-dark-burger" style="border-bottom: 1px solid #475569; height: 1px; width: 25px;"></span>
                            <span class="border-1 d-block for-dark-burger" style="border-bottom: 1px solid #475569; height: 1px; width: 25px; margin: 6px 0;"></span>
                            <span class="border-1 d-block for-dark-burger" style="border-bottom: 1px solid #475569; height: 1px; width: 25px;"></span>
                        </button>
                    </li>
                    <li>
                        <form class="src-form position-relative">
                            <input type="text" class="form-control" placeholder="Search here...">
                            <div class="src-btn position-absolute top-50 start-0 translate-middle-y bg-transparent p-0 border-0">
                                <span class="material-symbols-outlined">search</span>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
            --}}
        </div>
        <div class="col-md-6">
            <div class="right-header-content mt-3 mt-md-0">
                <ul class="d-flex align-items-center justify-content-center justify-content-md-end ps-0 mb-0 list-unstyled">
                    <li class="header-right-item light-dark-item">
                        <div class="light-dark">
                            <button class="switch-toggle dark-btn p-0 bg-transparent lh-0 border-0" id="switch-toggle">
                                <span class="dark"><i class="ri-moon-line fs-22"></i></span> 
                                <span class="light"><i class="ri-sun-line fs-22"></i></span>
                            </button>
                        </div>
                    </li>
                    <li class="header-right-item">
                        <div class="dropdown notifications noti">
                            <button class="btn btn-secondary border-0 p-0 position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-notification-3-line fs-22"></i>
                                <span class="count">0</span>
                            </button>
                            <div class="dropdown-menu dropdown-lg p-0 border-0 p-0 dropdown-menu-end">
                                <div class="d-flex justify-content-between align-items-center title">
                                    <span class="fw-medium fs-16 text-secondary">Notifications <span class="fw-normal text-body fs-16">(0)</span></span>
                                    <button class="p-0 m-0 bg-transparent border-0 fs-15 text-primary fw-medium">Clear All</button>
                                </div>
                                <div style="max-height: 300px;" data-simplebar>
                                    <div class="p-4 text-center">
                                        <p class="mb-0 text-muted small">No new notifications</p>
                                    </div>
                                </div>
                                <a href="#" class="dropdown-item text-center text-primary d-block view-all fw-medium rounded-bottom-3">
                                    <span>See All Notifications </span>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="header-right-item">
                        <div class="dropdown admin-profile">
                            <div class="d-xxl-flex align-items-center bg-transparent border-0 text-start p-0 cursor dropdown-toggle" data-bs-toggle="dropdown">
                                <div class="flex-shrink-0 position-relative">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="ri-user-fill fs-20 text-secondary"></i>
                                    </div>
                                    <span class="d-block bg-success border border-2 border-white rounded-circle position-absolute end-0 bottom-0" style="width: 11px; height: 11px;"></span>
                                </div>
                            </div>
                            <div class="dropdown-menu border-0 bg-white dropdown-menu-end shadow">
                                <div class="d-flex align-items-center info p-3 border-bottom">
                                    <div class="flex-grow-1 ms-2">
                                        <h3 class="fw-bold fs-15 mb-0 text-secondary">{{ Auth::user()->name.' '.Auth::user()->surname }}</h3>
                                        <span class="fs-13 text-muted">{{ ucwords(Auth::user()->role->name) }}</span>
                                    </div>
                                </div>
                                <ul class="admin-link mb-0 list-unstyled p-2">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center text-body py-2 rounded" href="{{ url(Auth::user()->role->name.'/profile') }}">
                                            <i class="ri-user-line me-2"></i>
                                            <span>My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider opacity-10">
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center text-body py-2 rounded" href="{{ url('auth/logout') }}">
                                            <i class="ri-logout-box-line me-2"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>