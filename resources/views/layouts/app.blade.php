@extends('layouts.master')

@section('master')
    
    <div class="row h-100 w-100 align-items-start g-0">
        <div id="sidebar" class="sidebar bg-light h-100 overflow-auto border-end border-1">
            <div class="d-flex align-items-center my-3 px-4 overflow-hidden">
                <div class="me-3">
                    <i style="font-size: 2.2rem;" class="bi bi-shield-lock"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="fs-5 lh-sm fw-bold">{{ config('app.name') }}</div>
                    <div class="lh-sm" style="font-size: 0.9rem;">ADMINISTRATOR</div>
                </div>
            </div>

            <nav class="px-3 pb-4">

                @foreach(config("menu") as $menu)
                    <div class="menu">
                        <a href="{{ url($menu['url']) }}" class="{{ strpos(url()->current(), $menu['url']) !== false ? "active" : "" }}">
                            {!! $menu['icon'] !!} {{ $menu['label'] }}
                        </a>
                    </div>
                @endforeach
                
            </nav>
        </div>

        <div class="col h-100 overflow-auto">
            <div class="sticky-top">
                <div class="d-flex align-items-center justify-content-between px-3 px-md-5 py-2 py-md-3 w-100 border-bottom border-1 bg-white">

                    <div class="d-flex d-xl-none align-items-center">
                        <button type="button" id="sidebar-button" class="btn btn-link btn-sm fs-4"><i class="bi bi-list"></i></button> 
                        <span class="fs-5 fw-bold">{{ config('app.name') }}</span>
                    </div>
                    <div class="text-muted d-none d-xl-block text-truncate">
                        {{ \Illuminate\Foundation\Inspiring::quote() }}
                    </div>

                    <div class="flex-shrink-0 d-flex">
                        <div class="me-4 d-none d-md-block">
                            <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                        </div>
                        <div>
                            <a href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-3 p-md-5">
                @section('content-max-width', '1200px')
                <div class="mx-auto" style="max-width: @yield('content-max-width');">

                    @if(session('success'))
                    <div class="alert-special alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check2 me-2 fs-4"></i>
                            <div class="flex-grow-1">
                                {{ session('success') }}
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert-special alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check2 me-2 fs-4"></i>
                            <div class="flex-grow-1">
                                {{ session('error') }}
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </div>

        </div>
    </div>

    <div id="sidebar-overlay" class="overlay position-absolute top-0 end-0 bottom-0 start-0"></div>

@endsection

@push('js')
<script>
    const sidebar = document.getElementById('sidebar-button');
    sidebar.addEventListener('click', function(e) {
        e.preventDefault();

        name = "showed";
        arr = document.getElementById('sidebar').className.split(" ");
        if (arr.indexOf(name) == -1) {
            document.getElementById('sidebar').className += " " + name;
        }

        name = "showed";
        arr = document.getElementById('sidebar-overlay').className.split(" ");
        if (arr.indexOf(name) == -1) {
            document.getElementById('sidebar-overlay').className += " " + name;
        }
    });


    const overlay = document.getElementById('sidebar-overlay');
    overlay.addEventListener('click', function(e) {
        var element = document.getElementById('sidebar');
        element.className = element.className.replace(/\bshowed\b/g, "");

        var element = document.getElementById('sidebar-overlay');
        element.className = element.className.replace(/\bshowed\b/g, "");
    });
</script>
@endpush