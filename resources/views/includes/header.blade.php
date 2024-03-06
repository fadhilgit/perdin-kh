    <head>
        <meta charset="utf-8" />
        <title>e-PERDIN KH</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Disposisi KH" name="description" />
        <meta content="MyraStudio" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{asset('')}}public/assets/css/loader.css" rel="stylesheet" type="text/css" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('') }}public/assets/images/logo-kwarsa1.png">

        <!-- App css -->
        <link href="{{asset('')}}public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('')}}public/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('')}}public/assets/css/theme.min.css" rel="stylesheet" type="text/css" />

        <!-- Plugin -->
        <link href="{{asset('')}}public/assets/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
        <link rel="manifest" href="{{asset('')}}public/manifest.json">
        <script>
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('{{asset('')}}public/service-worker.js')
                    .then(function(registration) {
                        console.log('Service Worker registered with scope:', registration.scope);
                    })
                    .catch(function(error) {
                        console.error('Service Worker registration failed:', error);
                    });
            }
        </script>


        @stack('styles')

    </head>
