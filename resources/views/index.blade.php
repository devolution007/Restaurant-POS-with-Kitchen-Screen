<html lang="{{ config('app.locale', 'en') }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ config('app.name', 'Restaurant POS') }}</title>
        <link rel="shortcut icon" href="{{ $fav_icon ?? '' }}" />
        <link href="{{ url(mix('css/app.css')) }}" rel="stylesheet" />
        <link href="{{ url('/css/custom-style.css') }}" rel="stylesheet" />
    </head>
    <body dir="{{config('app.direction','ltl')}}">
         @if(config('app.demo_mode'))
    <div class="bg-yellow-500 border border-yellow-600 text-black text-sm px-5 md:flex justify-between">
      <span><a href="https://codehas.gitbook.io/restaurant-pos/" target="_blank" rel="noopener">Click for documentation</a></span>
      <span>This is demo mode</span>
      <span>Bug report at <a href="mailto:info.codehas@gmail.com" rel="noopener" target="_blank">info.codehas@gmail.com</a></span>
      <span>v {{ config('app.version') }}</span>
  </div>
  @endif
        <div id="app">
            <div class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white">
                <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-cyan-900 border-t-transparent"></div>
            </div>
        </div>
        <script>
            window.app = {!! json_encode( $app_data, JSON_THROW_ON_ERROR) !!};
        </script>
        @routes
        <script src="{{ url(mix('js/app.js')) }}"></script>
    </body>
</html>
