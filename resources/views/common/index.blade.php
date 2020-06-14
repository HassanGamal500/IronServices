<!DOCTYPE html>
<html lang="en">
@include('common.meta')
<body class="layout-semi-dark">
<!-- Start Page Loading -->
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
@include('common.nav')
<div id="main">
    <div class="wrapper">
        @include('common.sidebar')
        @yield('content')
    </div>
</div>
@include('common.footer')
@include('common.script')
<!-- End Page Loading -->
</body>

</html>
