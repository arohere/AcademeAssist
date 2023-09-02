<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Dashboard {{ config('app.name') }}</title>
    <!-- CSS files -->
    <link href="{{ asset("tabler/css/tabler.min.css") }}" rel="stylesheet"/>
    <link href="{{ asset("tabler/css/tabler-flags.min.css") }}" rel="stylesheet"/>
    {{-- <link href="{{ asset("tabler/css/tabler-payments.min.css") }}" rel="stylesheet"/> --}}
    <link href="{{ asset("tabler/css/tabler-vendors.min.css") }}" rel="stylesheet"/>
    <link href="{{ asset("tabler/css/demo.min.css") }}" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @yield('css')
    {{-- START Ziggy Routes --}}
    {{-- END Ziggy Routes --}}
  </head>
  <body>
    @include('sweetalert::alert')
    <div class="page">
      @include('layouts.partials.tabler.header')
      @include('layouts.partials.tabler.navbar')

      <div class="page-wrapper">


        <div class="page-body">
            @yield('content')
        </div>

        @include('layouts.partials.tabler.footer')
      </div>
    </div>


    <!-- Libs JS -->
    <script src="{{ asset("tabler/js/demo-theme.min.js") }}"></script>
    <script src="{{ asset("tabler/libs/apexcharts/dist/apexcharts.min.js") }}" defer></script>
    <script src="{{ asset("tabler/libs/jsvectormap/dist/js/jsvectormap.min.js") }}" defer></script>
    <script src="{{ asset("tabler/libs/jsvectormap/dist/maps/world.js") }}" defer></script>
    <script src="{{ asset("tabler/libs/jsvectormap/dist/maps/world-merc.js") }}" defer></script>
    <!-- Tabler Core -->
    <script src="{{ asset("tabler/js/tabler.min.js") }}" defer></script>
    <script src="{{ asset("tabler/js/demo.min.js") }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/libs/tinymce/tinymce.min.js" defer></script>

    @yield('js')

  </body>
</html>
