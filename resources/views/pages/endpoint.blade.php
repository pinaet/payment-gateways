<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Payment Methods - Summer Programmes</title>

    <link rel="stylesheet" href="css/app.css?{{ time() }}">

    @include('pages.partials.favicon')

</head>

<body>
    <div id="app" class="page-wrapper bg-red p-t-30 p-b-30 font-robo">
        <div class="wrapper wrapper--w960">
            <div class="card card-2">
                <div class="card-heading"><img class="card-img" src="images/HarrowWhiteLogo.png"></center></div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-9">
                        </div>
                    </div>
                    <h2 class="title">Payment Method</h2>
                    <form id="orderForm" method="POST" v-on:submit.prevent="postIt">
                        <input type="hidden" name="order"     value="{{json_encode($order)}}">

                        <button type="submit" class="btn btn-secondary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main JS-->
    <!-- <script src="js/global.js"></script> -->
    <script src="{{ url('js/endpoint.js?'). config('app.version') }}"></script>    


</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->