@include('layouts.navbars.nav')a
<div class="wrapper wrapper-full-page ">
    <div class="full-page section-image" filter-color="black" data-image="{{ asset('img') . '/' . ($backgroundImagePath ?? "/home_background.png") }}">
        <main class="py-4">
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>
</div>
