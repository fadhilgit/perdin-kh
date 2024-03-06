
<div id="loading" class="loading">
    <div class="la-ball-atom la-dark la-3x">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('load', function() {
            // Hide the loading element when the page has fully loaded
            document.getElementById('loading').style.display = 'none';
        });
    </script>
@endpush
