<template>

        <div class="page-wrapper bg-red p-t-30 p-b-30 font-robo">
            <div class="wrapper wrapper--w960">
                <div class="card card-2">
                    <div class="card-heading"><img class="card-img" src="images/HarrowWhiteLogo.png"></div>

                    <div class="card-body" style="padding-bottom: 45px;">
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-9"></div>
                        </div>
                        <h2 class="title">{{endpoint.name ? endpoint.name : 'Payment Method' }}</h2>
                        <!-- <form id="orderForm" method="POST" v-on:submit.prevent> -->
                            <div class="payment-options">
                                <div class="form-group row">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="payment_methods" id="card" @change="changeSourceType('card')">
                                        <label class="form-check-label" for="card"><img src="../../images/card.jpg" width="80%"></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="payment_methods" id="unionpay" @change="changeSourceType('unionpay')">
                                        <label class="form-check-label" for="unionpay"><img src="../../images/unionpay.jpg" width="80%"></label>
                                        <!-- <label class="form-check-label" for="unionpay"><img src="../../images/unionpay-gray.jpg" width="80%"></label> -->
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <template v-if="kbankService">
                                            <input class="form-check-input" type="radio" name="payment_methods" id="wechat" @change="changeSourceType('wechat')">
                                            <label class="form-check-label" for="wechat"><img src="../../images/wechat.jpg" width="80%"></label>
                                        </template>
                                        <template v-else>
                                            <label class="form-check-label" for="wechat"><img src="../../images/wechat-gray.jpg" width="80%"></label>
                                        </template>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="payment_methods" id="alipay" @change="changeSourceType('alipay')">
                                        <label class="form-check-label" for="alipay"><img src="../../images/alipay.jpg" width="80%"></label>
                                        <!-- <label class="form-check-label" for="alipay"><img src="../../images/alipay-gray.jpg" width="80%"></label> -->
                                    </div>
                                </div>
                            </div>
                            <table width="100%">
                                <tr>
                                    <td class="payment-td-title" width="40%">Selected Payment Method</td>
                                    <td class="payment-td-content" width="60%">
                                        <input type="text" readonly class="form-control-plaintext p-0" v-model="sourceType.name">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="payment-td-title">Product Detail</td>
                                    <td class="payment-td-content">
                                        <input type="text" readonly class="form-control-plaintext p-0" :value="order.description">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="payment-td-title">Reference Number</td>
                                    <td class="payment-td-content">
                                        <input type="text" readonly class="form-control-plaintext p-0" :value="order.reference_order">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="payment-td-title">Cost</td>
                                    <td class="payment-td-content">
                                        <input type="text" readonly class="form-control-plaintext p-0" :value="c_amount">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="payment-td-title">Service Fee</td>
                                    <td class="payment-td-content">
                                        <input type="text" readonly class="form-control-plaintext p-0" :value="c_service_fee">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="payment-td-title">Total Amount</td>
                                    <td class="payment-td-content">
                                        <input type="text" readonly class="form-control-plaintext p-0 red-amount" :value="c_total_amount">
                                    </td>
                                </tr>
                            </table>
                        <!-- </form> -->
                        <center>
                            <div id="div_pay" class="p-t-30" >
                                <form method="POST" action="">
                                    <script type="application/javascript"
                                        :src            ="gateConf[ gateConf.mode ].kbank.src"
                                        data-show-button=false
                                    >
                                    </script>
                                </form>
                                <button id="paynow" class="btn btn--radius btn--harrow" @click="paySubmit">Pay Now</button>
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
                                                <td class="payment-td-content"  style="border-left: none" v-bind:class="{'fee-tbank': sourceType.bank=='tbank'}">Visa/MasterCard</td>
                                                <td class="payment-td-content text-center"  style="border-right: none" v-bind:class="{'fee-tbank': sourceType.bank=='tbank'}">{{getBankFee('tbank')}}%</td>
                                            </tr>
                                            <tr>
                                                <td class="payment-td-content" style="border-left: none" v-bind:class="{'fee-kbank': sourceType.bank=='kbank'}">UnionPay, WeChat Pay, Alipay</td>
                                                <td class="payment-td-content text-center" style="border-right: none" v-bind:class="{'fee-kbank': sourceType.bank=='kbank'}">{{getBankFee('kbank')}}%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </center>
                    </div>
                </div>
                <div id="dd" style="color: white"></div>
            </div>
        </div>

</template>

<script>

export default {
    data() {
        return {
            order: '',
            endpoint: '',
            sourceType: '',
            sourceTypes: '',
            gateConf: '',
            service_fee: 0,
            total_amount: 0,
            initCount: 0,
            payload: '',
            payment: '',
            timer: '',
            kbankService: '',
        }
    },
    props: [ 'csrfToken', 'orderRaw', 'endpointRaw', 'sourceTypesRaw', 'gateConfRaw', 'kbankServiceRaw' ],
    components: {
    },
    beforeMount(){
        this.gateConf    = JSON.parse( this.gateConfRaw    )
    },
    mounted() {
        this.order       = JSON.parse( this.orderRaw       )
        this.endpoint    = JSON.parse( this.endpointRaw    )
        this.sourceTypes = JSON.parse( this.sourceTypesRaw )
        this.kbankService= JSON.parse( this.kbankServiceRaw)
    },
    methods: {
        getBankFee( method ){
            if( this.endpoint.charge_fee=='y'){
                for( let i=0; i<this.sourceTypes.length; i++ ){
                    if(this.sourceTypes[i].bank==method){
                        return this.numberWithCommas( parseFloat(this.sourceTypes[i].rate * 100).toFixed(2) )
                    }
                }
            } else {
                return 0
            }
        },
        changeSourceType( method ){
            var found      = false
            for( let i=0; i<this.sourceTypes.length; i++ ){
                if(this.sourceTypes[i].source_type==method){
                    this.sourceType = this.sourceTypes[i]
                    found           = true
                }
            }

            /* the selected method is under maintenance */
            if( this.sourceType.close_status==1 ){
                alert(this.sourceType.close_message)
                this.clearAllSelected()
                return false
            }

            /* the selected method is ready for payment */
            if(this.sourceType.bank=='kbank'){
                $('#paynow').removeClass('btn--harrow').
                             removeClass('btn--orange').
                             addClass('btn--green')
            }
            else if(this.sourceType.bank=='tbank'){
                $('#paynow').removeClass('btn--harrow').
                             removeClass('btn--green').
                             addClass('btn--orange')
            }
            else {
                this.clearPaymentButton()
            }

            if( !found ) {
                alert( 'No payment method found!' )
            }
            else {
                if( this.endpoint.charge_fee=='y'){
                    this.rate           = this.sourceType.rate
                } else {
                    this.rate = 0
                }
                this.service_fee        = this.order.amount * this.rate
                this.total_amount       = parseFloat((parseFloat(this.order.amount) + this.service_fee).toFixed(2))

                this.order.total_amount  = this.total_amount
                this.order.source_type_id= this.sourceType.id
                this.order.source_type   = this.sourceType.source_type

                /**
                 * retrieve payment gateway data
                 */
                if( this.sourceType.bank=='kbank' ){
                    var dest = this.gateConf[ this.gateConf.mode ].base_url + this.gateConf[ this.sourceType.source_type ].create

                    axios.post( dest, {
                        order: JSON.stringify( this.order ),
                    })
                    .then( (response) => {
                        var data = JSON.parse( JSON.stringify( response.data ) )
                        this.payload = data.payload
                        this.payment = data.payment
                    })
                }
            }

        },
        clearAllSelected()
        {
            this.service_fee    = 0.0
            this.total_amount   = 0.0
            this.sourceType     = ''

            var ele = document.getElementsByName('payment_methods');
            for(var i=0;i<ele.length;i++)
               ele[i].checked = false;

            this.clearPaymentButton()
        },
        clearPaymentButton()
        {
            $('#paynow').removeClass('btn--orange').
                         removeClass('btn--green').
                         addClass('btn--harrow')
        },
        paySubmit() {
            if( this.sourceType=='' ){
                alert( 'Please select a payment method' )
                return false
            }
            var form     = $('#div_pay').find('form')
            var action   = ''
            var base_url = this.gateConf[ this.gateConf.mode ].base_url
            var dest     = base_url + this.gateConf[ this.sourceType.source_type ].store
            var order_url= './order/source-type'

            if(      this.sourceType.bank=='tbank' )
            {
                if(      this.sourceType.source_type=='card' )
                {
                    /*
                    $product_id		  = $_POST['product_id']; //must be empty for 'product_name'
                    $reference_order  = $_POST['reference_order'];
                    $amount			  = $_POST['amount'];
                    $currency		  = $_POST['currency'];
                    $customer_id	  = $_POST['customer_id'];
                    $customer_name	  = $_POST['customer_name'];
                    $customer_email	  = $_POST['customer_email'];
                    $customer_phone	  = $_POST['customer_phone'];
                    $autoredirect	  = $_POST['autoredirect']; //must be 'Y' to get callback
                    $posturl		  = $_POST['posturl'];
                    $product_name	  = $_POST['product_name'];
                     */

                    //add input into the form
                    let callback_url  = this.gateConf[ this.gateConf.mode ].url + '/order/t-callback';

                    $("<input />").attr("type", "hidden").attr("name", "reference_order").attr("value", this.order.reference_order).appendTo( form );
                    $("<input />").attr("type", "hidden").attr("name", "amount"         ).attr("value", this.order.total_amount   ).appendTo( form );
                    $("<input />").attr("type", "hidden").attr("name", "currency"       ).attr("value", this.order.currency       ).appendTo( form );
                    $("<input />").attr("type", "hidden").attr("name", "autoredirect"   ).attr("value", 'Y'                       ).appendTo( form );
                    $("<input />").attr("type", "hidden").attr("name", "posturl"        ).attr("value", callback_url              ).appendTo( form );
                    $("<input />").attr("type", "hidden").attr("name", "customer_name"  ).attr("value", this.order.ref            ).appendTo( form );
                    $("<input />").attr("type", "hidden").attr("name", "customer_email" ).attr("value", this.order.customer_email ).appendTo( form );
                    $("<input />").attr("type", "hidden").attr("name", "product_name"   ).attr("value", this.order.description    ).appendTo( form );

                    action        = this.gateConf[ this.gateConf.mode ].tbank.gate
                    form.attr( 'action', action )

                    /** store payment transaction */
                    /** update order : source_type_id, source_type, payment_result, status */
                    // var data = JSON.parse( JSON.stringify( response.data ) )
                    console.log( this.order )
                    this.payload = { "amount" : this.order.total_amount }
                    axios.post( order_url, {
                        order:      JSON.stringify( this.order ),
                        payload:    JSON.stringify( this.payload ),
                    })
                    .then( (response) => {
                        var data = response.data

                        $('#dd').html( data )
                        form.submit()
                    })
                }
            }
            else if( this.sourceType.bank=='kbank' )
            {
                KPayment.setPublickey(      this.payment.pkey        )
                KPayment.setPaymentMethods( this.payload.source_type )
                KPayment.setAmount(         this.payload.amount      )
                KPayment.setCurrency(       this.payload.currency    )

                if( this.sourceType.source_type=='unionpay' || this.sourceType.source_type=='alipay' ){
                    action  = this.payload.redirect_url
                    form.attr( 'action', action )
                    KPayment.setOrderId('')

                    /** store payment transaction */
                    console.log( this.order )
                    axios.post( dest, {
                        order:      JSON.stringify( this.order ),
                        payload:    JSON.stringify( this.payload ),
                    })
                    .then( (response) => {
                        /** update order : source_type_id, source_type, payment_result, status */
                        // var data = JSON.parse( JSON.stringify( response.data ) )
                        axios.post( order_url, {
                            order:      JSON.stringify( this.order ),
                            payload:    JSON.stringify( this.payload ),
                        })
                        .then( (response) => {
                            var data = response.data

                            $('#dd').html( data )
                            form.submit()
                        })
                    })
                }
                else if( this.sourceType.source_type=='wechat' ){
                    action  = base_url + this.gateConf[ this.sourceType.source_type ].callback
                    form.attr( 'action', action )
                    KPayment.setOrderId( this.payload.id )

                    /** store payment transaction */
                    axios.post( dest, {
                        order:      JSON.stringify( this.order ),
                        payload:    JSON.stringify( this.payload ),
                    })
                    .then( (response) => {
                        /** update order : source_type_id, source_type, payment_result, status */
                        // var data = JSON.parse( JSON.stringify( response.data ) )
                        axios.post( order_url, {
                            order:      JSON.stringify( this.order ),
                            payload:    JSON.stringify( this.payload ),
                        })
                        .then( (response) => {
                            var data = response.data

                            $('#dd').html( data )

                            //check transaction status every 3 seconds
                            this.timer = setInterval( this.checkPaymentStatus, 3000 )

                            //remove transaction if K pop us is closed without completed payment
                            KPayment.onClose( this.popUpClosed )

                            KPayment.show()
                        })
                    })
                }
            }
            else
            {

            }
        },
        numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        checkPaymentStatus(){
            console.log( 'checkPaymentStatus...' + this.payload.id )
            var base_url = this.gateConf[ this.gateConf.mode ].base_url
            var dest     = base_url + this.gateConf[ this.sourceType.source_type ].check
            axios.post( dest, {
                ref: this.order.ref,
                order_id: this.payload.id
            } )
            .then( (response) => {
                let data = response.data

                let payment_status = data.payment_status
                let charge_id      = data.charge_id
                if( payment_status=='completed' ){
                    let form     = $('#div_pay').find('form')
                    let action   = ''
                    clearInterval( this.timer )
                // if the payment is already successful then submit the form to payment callback
                    action   = base_url + this.gateConf[ this.sourceType.source_type ].callback
                    form.attr( 'action', action )

                    $('<input>').attr({
                        type: 'hidden',
                        name: 'chargeId',
                        value: charge_id,
                    }).appendTo( form );

                    form.submit()
                }
            })
        },
        popUpClosed(){
            console.log( 'K pop-up is closed' )
            clearInterval( this.timer )
            //remove the order and trans from database: /kbank/wechat/remove
            var base_url = this.gateConf[ this.gateConf.mode ].base_url
            var dest     = base_url + this.gateConf[ this.sourceType.source_type ].remove
            axios.post( dest, {
                ref: this.order.ref,
                order_id: this.payload.id
            } )
            .then( (response) => {
                let data     = response.data
                let form     = $('#div_pay').find('form')
                let action   = ''

                $('input[name=chargeId]').remove()

            })
        }
    },
    computed: {
        c_amount() {
            let num = this.numberWithCommas( parseFloat(this.order.amount).toFixed(2) )
            return  num + ' ' + this.order.currency
        },
        c_service_fee() {
            let num = this.numberWithCommas( parseFloat(this.service_fee).toFixed(2) )
            return  num + ' ' + this.order.currency
        },
        c_total_amount() {
            let num = this.numberWithCommas( parseFloat(this.total_amount).toFixed(2) )
            return  num + ' ' + this.order.currency
        },
    }
}
</script>

<style>
.fee-tbank{
    font-weight: bold;
    color: #FE6429;
}
.fee-kbank{
    font-weight: bold;
    color: #00A850;
}
</style>
