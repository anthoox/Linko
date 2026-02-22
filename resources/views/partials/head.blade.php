<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="{{ asset('assets/img/logo-linko-transparent.ico') }}" sizes="any">
<!-- <link rel="icon" href="/favicon.svg" type="image/svg+xml"> -->
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

@vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
@fluxAppearance