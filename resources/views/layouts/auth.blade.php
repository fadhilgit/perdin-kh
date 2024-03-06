<!DOCTYPE html>
<html lang="en">
<style>
    .loading {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 100;
    }
</style>
@include('includes.header')

<body class="bg-primary">
    <div id="loading" class="loading">
        <div class="la-ball-atom la-dark la-3x">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    @yield('content')

    @include('includes.footer')
    <script>
        window.addEventListener('load', function() {
            // Hide the loading element when the page has fully loaded
            document.getElementById('loading').style.display = 'none';
        });
    </script>
</body>

</html>
