<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FEDAC - Carta etnografica') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    @include('tracking.googleanalytics')
</head>
<body>

<div class="ffb-id-navigation-header wrapper ff-boxed-wrapper">
    <div class="wrapper-top-space"></div>
    @include('layouts.partials.header')
    <div class="page-wrapper">

        @include('layouts.partials.main_image')
        @include('layouts.partials.submenu')

        <section class="ffb-id-23a5jmvo fg-section fg-text-dark">
            <div class="fg-container container fg-container-large fg-container-lvl--1 ">
                <div class="fg-row row    ">
                    <div class="ffb-id-23a5jmvp fg-col col-xs-12 col-sm-12 col-md-4 fg-el-has-bg fg-text-dark"><span class="fg-bg"><span data-fg-bg="{&quot;type&quot;:&quot;color&quot;,&quot;opacity&quot;:1,&quot;color&quot;:&quot;#086c00&quot;}" class="fg-bg-layer fg-bg-type-color " style="opacity: 1; background-color: #086c00;"></span></span>
                        <h1 class="ffb-id-23a5jmvr fg-heading text-center    fg-text-dark"><p><span style="background-color: #086c00;color: #ffffff">ACCESO A LAS FICHAS<br/></span></p></h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="ffb-id-2h51fn7v fg-section fg-text-dark">
            <div class="fg-container container fg-container-large fg-container-lvl--1 ">
                <div class="fg-row row    ">
                    <div class="ffb-id-2n0ocp1j fg-col col-xs-12 col-md-12 fg-text-dark">
                        <div class="ffb-id-2n0ocson embed-video-external">
                            <div class="embed-responsive">
                                <div class="container py-5">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('layouts.partials.footer')
    </div>
</div>
<a href="javascript:void(0);" class="js-back-to-top back-to-top-theme"></a>
<div
    class="hidden smoothscroll-sharplink"
    data-speed="1000"
    data-offset="0"
></div>

<!-- Scripts -->
<script src="{{ asset('js/manifest.js') }}"></script>
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/plugins.js') }}"></script>

<!-- App scripts -->
@stack('scripts')
</body>
</html>

