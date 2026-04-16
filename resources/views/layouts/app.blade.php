<!DOCTYPE html>
<html lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="{{ asset('assets/css/sidebar-menu.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/simplebar.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/prism.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/quill.snow.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/jsvectormap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        
        <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
        
        <title>eduLink</title>
    </head>
    <body class="bg-body-bg">
        @if(!Auth::guest())
        <div class="sidebar-area" id="sidebar-area">
            <div class="logo position-relative d-flex align-items-center justify-content-between">
                <a href="{{ url('/') }}" class="d-block text-decoration-none position-relative">
                    <img src="{{ asset('assets/images/logo-icon.png') }}" alt="logo-icon">
                    <span class="logo-text text-secondary fw-semibold">eduLink</span>
                </a> 
                <button class="sidebar-burger-menu-close bg-transparent py-3 border-0 opacity-0 z-n1 position-absolute top-50 end-0 translate-middle-y" id="sidebar-burger-menu-close">
                    <span class="border-1 d-block for-dark-burger" style="border-bottom: 1px solid #475569; height: 1px; width: 25px; transform: rotate(45deg);"></span>
                    <span class="border-1 d-block for-dark-burger" style="border-bottom: 1px solid #475569; height: 1px; width: 25px; transform: rotate(-45deg);"></span>
                </button>
                <button class="sidebar-burger-menu bg-transparent p-0 border-0" id="sidebar-burger-menu">
                    <span class="border-1 d-block for-dark-burger" style="border-bottom: 1px solid #475569; height: 1px; width: 25px;"></span>
                    <span class="border-1 d-block for-dark-burger" style="border-bottom: 1px solid #475569; height: 1px; width: 25px; margin: 6px 0;"></span>
                    <span class="border-1 d-block for-dark-burger" style="border-bottom: 1px solid #475569; height: 1px; width: 25px;"></span>
                </button>
            </div>
            @if(Request::segment(1) == 'su')
                @include('livewire.partials.su_nav')
            @elseif(Request::segment(1) == 'admin')
                @include('livewire.partials.admin_nav')
            @elseif(Request::segment(1) == 'tutor')
                @include('livewire.partials.tutor_nav')
            @elseif(Request::segment(1) == 'student')
                @include('livewire.partials.student_nav')
            @endif
        </div>
        @endif
        <div class="container-fluid">
            <div class="main-content d-flex flex-column">
                @if(!Auth::guest())
                    <livewire:partials.header />
                @endif
                <div class="main-content-container overflow-hidden">
                    {{ $slot }}
                </div>
                @if(!Auth::guest())
                <div class="flex-grow-1"></div>
                <footer class="footer-area bg-white text-center rounded-10 rounded-bottom-0">
                    <p class="fs-16 text-body">© <span class="text-secondary">eduLink</span></p>
                </footer>
                @endif
            </div>
        </div>

        <button class="switch-toggle dark-btn p-0 bg-transparent lh-0 border-0" id="switch-toggle"></button>
        
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
        <script src="{{ asset('assets/js/quill.min.js') }}"></script>
        <script src="{{ asset('assets/js/data-table.js') }}"></script>
        <script src="{{ asset('assets/js/prism.js') }}"></script>
        <script src="{{ asset('assets/js/clipboard.min.js') }}"></script>
        <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/js/echarts.min.js') }}"></script>
        <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/fullcalendar.main.js') }}"></script>
        <script src="{{ asset('assets/js/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('assets/js/world-merc.js') }}"></script>
        <script src="{{ asset('assets/js/custom/apexcharts.js') }}"></script>
        <script src="{{ asset('assets/js/custom/echarts.js') }}"></script>
        <script src="{{ asset('assets/js/custom/maps.js') }}"></script>
        <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
    <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9d2625a28a9c73c4',t:'MTc3MTg0MzY2Ng=='};var a=document.createElement('script');a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>