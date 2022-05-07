<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{csrf_token()}}">

    @routes 
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ asset(mix('js/manifest.js')) }}" defer></script>
    <script src="{{ asset(mix('js/vendor.js')) }}" defer></script>
    <script src="{{ mix('/js/app.js') }}" defer></script>
    @inertiaHead
  </head>
  <body>
    @inertia
    <script src="{{ mix('/js/apexcharts.min.js') }}" defer></script>
    <script src="{{ mix('/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ mix('/js/countUp.js') }}" defer></script>
    <script src="{{ mix('/js/litepicker.js') }}" defer></script>
    <script src="{{ mix('/js/nouislider.min.js') }}" defer></script> 
    <script src="{{ mix('/js/tom-select.base.min.js') }}" defer></script> 
  </body>
</html>