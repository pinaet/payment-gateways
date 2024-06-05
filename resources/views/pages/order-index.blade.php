<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title Page-->
    <title>Payment Methods{{ empty($endpoint->name) ? '' : ' - ' . $endpoint->name }}</title>

    <link rel="stylesheet" href="{{ url('css/app.css?'). config('app.version') }}">

    @include('pages.partials.favicon')

</head>

<body>
    <div id="app">
        {{-- vue component --}}
        <payment-methods-panel
            csrf-token          ="{{csrf_token()}}"
            order-raw           ="{{json_encode($order)}}"
            endpoint-raw        ="{{json_encode($endpoint)}}"
            source-types-raw    ="{{json_encode($sourceTypes)}}"
            gate-conf-raw       ="{{json_encode($gateConf)}}"
            kbank-service-raw   ="{{env('KBANK_SERVICE', true)}}">
        </payment-methods-panel>
    </div>

    <!-- Main JS-->
    <!-- <script src="js/global.js"></script> -->
    {{-- <script src="{{ config('gate.' . config('gate.mode') . '.kbank.src') }}" data-show-button=false></script> --}}
    <script src="{{ url('js/order.js?'). config('app.version') }}"></script>


</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->
