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
                    <form method="POST" v-on:submit.prevent>
                        <div class="payment-options">
                            <div class="form-group row">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment_methods" id="card" value="card">
                                    <label class="form-check-label" for="card"><img src="images/card.jpg" width="80%"></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment_methods" id="union" value="union">
                                    <label class="form-check-label" for="union"><img src="images/unionpay.jpg" width="80%"></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment_methods" id="wechat" value="wechat">
                                    <label class="form-check-label" for="wechat"><img src="images/wechat.jpg" width="80%"></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment_methods" id="alipay" value="alipay">
                                    <label class="form-check-label" for="alipay"><img src="images/alipay.jpg" width="80%"></label>
                                </div>
                            </div>
                        </div>
                        <table width="100%">
                            <tr>
                                <td class="payment-td-title" width="40%">Selected Payment Method</td>
                                <td class="payment-td-content" width="60%">
                                    <input type="text" readonly class="form-control-plaintext p-0" id="selected_method" value="">
                                </td>
                            </tr>
                            <tr>
                                <td class="payment-td-title">Product Detail</td>
                                <td class="payment-td-content">
                                    <input type="text" readonly class="form-control-plaintext p-0" id="description" value="Summer Course">
                                </td>
                            </tr>
                            <tr>
                                <td class="payment-td-title">Cost</td>
                                <td class="payment-td-content">
                                    <input type="text" readonly class="form-control-plaintext p-0" id="cost" value="">
                                </td>
                            </tr>
                            <tr>
                                <td class="payment-td-title">Service Fee</td>
                                <td class="payment-td-content">
                                    <input type="text" readonly class="form-control-plaintext p-0" id="service_fee" value="">
                                </td>
                            </tr>
                            <tr>
                                <td class="payment-td-title">Total Amount</td>
                                <td class="payment-td-content">
                                    <input type="text" readonly class="form-control-plaintext p-0 red-amount" id="total_amount" value="">
                                </td>
                            </tr>
                        </table>
                        <center>
                        <div class="p-t-30">
                            <button id="paynow" class="btn btn--radius btn--harrow" type="submit">Pay Now</button>
                        </div>
                        </center>                        
                        <br>
                        <center>
                            <div style="border: 1px solid #ddd; border-radius: 5px; width: 60%">                            
                                <table width="100%">
                                    <thead>
                                        <th width="60%" class="text-center">Payment Methods</th>
                                        <th width="40%" class="text-center">Service Fee</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="payment-td-content"  style="border-left: none">Visa/MasterCard</td>
                                            <td class="payment-td-content text-center"  style="border-right: none">1.3%</td>
                                        </tr>
                                        <tr>
                                            <td class="payment-td-content" style="border-left: none">UnionPay, WeChat Pay, Alipay</td>
                                            <td class="payment-td-content text-center" style="border-right: none">2.0%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main JS-->
    <!-- <script src="js/global.js"></script> -->
    <script src="js/app.js?{{ time() }}"></script>
    <script>
        $('input[type=radio]').on('change', function(){
            var rate   = 0
            var cost   = 10000
            var service_fee = 0
            var total  = 0
            var method = $(this).val()
            if( method=='card' ){
                $('#selected_method').val('Visa/Master Card')
                rate = 0.013
                service_fee = '130.00 THB'
                total  = '10,130.00 THB'
                $('#paynow').removeClass('btn--harrow').
                             removeClass('btn--green').
                             addClass('btn--orange')
            }
            else if( method=='alipay' ){
                $('#selected_method').val('AliPay')
                rate = 0.02
                service_fee = '200.00 THB'
                total  = '10,200.00 THB'
                $('#paynow').removeClass('btn--harrow').
                             removeClass('btn--orange').
                             addClass('btn--green')
            }
            else if( method=='wechat' ){
                $('#selected_method').val('WeChat Pay')
                rate = 0.02
                service_fee = '200.00 THB'
                total  = '10,200.00 THB'
                $('#paynow').removeClass('btn--harrow').
                             removeClass('btn--orange').
                             addClass('btn--green')
            }
            else if( method=='union' ){
                $('#selected_method').val('Union Pay')
                rate = 0.02
                service_fee = '200.00 THB'
                total  = '10,200.00 THB'
                $('#paynow').removeClass('btn--harrow').
                             removeClass('btn--orange').
                             addClass('btn--green')
            }
            $('#cost').val('10,000.00 THB')
            $('#service_fee').val( service_fee )
            $('#total_amount').val( total )
        });
    </script>


</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->