<!DOCTYPE HTML>
<html lang="en-GB">

<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title')</title>

    <!-- Fav Icon -->
    <link rel="icon" href="{{ asset('frontend/assets/images/fav_icon.png') }}">
    <!-- Style Sheets -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/blocks/youtube/view.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/theme.css') }}">

@yield('css')

<!-- jQuery  -->
    <script type="text/javascript" src="{{ asset('frontend/assets/js/jquery.js') }}"></script>

</head>

<body>
<div class="ccm-page ccm-page-id-1 page-type-page page-template-full">

    @include('master.frontend-include.header')

    <main>
        @yield('content')
    </main>

    @include('master.frontend-include.footer')

</div>

@yield('before_scripts')

<script type="text/javascript" src="{{ asset('frontend/assets/js/picturefill.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/iframeResizer.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/bootstrap/alert.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/bootstrap/transition.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/theme.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/bootstrap/collapse.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/bootstrap/tab.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/jquery_easing.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/jquery_hoverIntent.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/mega_menu.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/hamburger_menu.js') }}"></script>

<script src="{{ asset('frontend/assets/js/sweatalert.js') }}"></script>

@if(Session::has('message'))

    <script>
        $(document).ready(function () {
            Swal.fire(
                '{{ Session::get('heading', '') }}',
                '{{ Session::get('message') }}',
                '{{ Session::get('alert-type', 'info') }}'
            )
        });
    </script>

@endif


@yield('scripts')

<script type="text/javascript">
    $(document).ready(function () {

        const timeout = 150;
        let $block = $('#mega-menus');
        let $megaMenu = $block.find('.mega-menu').first();
        $megaMenu.megaMenu('init');

        $megaMenu.hoverIntent({
            over: function () {
            },
            out: closeMenu,
            interval: 25,
            timeout: timeout
        });

        let $megaMenuTriggers = $megaMenu.find('.trigger');
        $megaMenuTriggers.each(function () {
            $(this).hoverIntent({
                over: openMenu,
                out: function () {
                },
                interval: 25,
                timeout: timeout
            });
        });

        function openMenu() {
            $megaMenu.megaMenu('show', this);
        }

        function closeMenu() {
            $megaMenu.megaMenu('hide');
        }

        let $hamburgerMenu = $block.find('.hamburger-menu').first();
        $hamburgerMenu.on('click', '.hamburger', function () {
            $hamburgerMenu.hamburgerMenu('toggle');
        });
    });
</script>


</body>
</html>
