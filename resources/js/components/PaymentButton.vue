<template>  

                                <!-- <button id="paynow" class="btn btn--radius btn--harrow" type="submit">Pay Now</button> -->
                                <!-- <div id="div_pay">

                                </div> -->
                                <form id="form_pay" method="POST" action="">
                                </form>

</template>

<script>
import postscribe from 'postscribe'

export default {
    data() {
        return {
            order: '',
            sourceType: '',
            initCount: 0,
        }
    },
    props: [ 'orderRaw', 'sourceTypeRaw' ],
    mounted() {
        this.order       = JSON.parse( this.orderRaw      )
        this.sourceType  = JSON.parse( this.sourceTypeRaw )


        /*
        let k_script = document.createElement('script')
        k_script.setAttribute('type'                , 'application/javascript')
        k_script.setAttribute('src'                 , 'https://dev-kpaymentgateway.kasikornbank.com/ui/v2/kpayment.min.js')
        k_script.setAttribute('data-apikey'         , 'pkey_test_683yajTS8Owc9Tt1xxaHlm7DvUZ7LmKt4F')
        k_script.setAttribute('data-amount'         , '1')
        k_script.setAttribute('async'         , 'true')
        k_script.setAttribute('defer'         , 'true')
        let form = $('#form_pay')
        form.empty()
        if( this.sourceType.source_type=='wechat' ){
            form.attr( 'action', 'http://histest.harrowschool.ac.th/payment/public/kbank/wechat/callback' )
            k_script.setAttribute('data-payment-methods', 'wechat')
            k_script.setAttribute('data-order-id'       , 'order_test_68928c2cab67b64fba852e24f1882db108')
        }
        else if( this.sourceType.source_type=='alipay' ){
            form.attr( 'action', 'https://dev-kpaymentgateway-services.kasikornbank.com/KPGW-Redirect-Webapi/Alipay/redr_test_12345_00068_126' )
            k_script.setAttribute('data-payment-methods', 'alipay')
        }
        form.append(k_script)
        //*/
        //generate pay button
        
        // /*
        var date = new Date();
        var timestamp = date.getTime();
        var action  = ''
        var script  = '\
                        <script type="application/javascript" \
                        src="https://dev-kpaymentgateway.kasikornbank.com/ui/v2/kpayment.min.js?v='+timestamp+'" \
                        data-apikey="pkey_test_683yajTS8Owc9Tt1xxaHlm7DvUZ7LmKt4F" \
                        data-amount="1" '
        if( this.sourceType.source_type=='wechat' ){
            script += ' data-payment-methods="wechat" '
            script += ' data-order-id="order_test_68661d642a38b84a898b20775a5ec0420e"'
            action  = 'https://histest.harrowschool.ac.th/payment/public/kbank/wechat/callback'
        }
        else if( this.sourceType.source_type=='alipay' ){
            script += ' data-payment-methods="alipay" '
            action  = 'https://dev-kpaymentgateway-services.kasikornbank.com/KPGW-Redirect-Webapi/UPOP/redr_test_3e0fd45c342d4291baba1586bcfd80ec'
        }
        else{
            script += ' data-payment-methods="wechat" '
            script += ' data-order-id="order_test_68661d642a38b84a898b20775a5ec0420e"'
            action  = 'https://histest.harrowschool.ac.th/payment/public/kbank/wechat/callback'
        }

        if( action!='' ){
            script += '><'
            script += '/script>'
            
            $("#form_pay").attr( 'action', action )
            $("#form_pay").empty()
            
            postscribe('#form_pay', script )
            // var button = $('<input type="button" value="Pay Now" onclick="KPayment.show()">')
            // $("#form_pay").append( button )
            // var button = $('<button _kpayment="" type="button" class="pay-button"><span style="transition: all 0.5s ease 0s;"></span></button>')
            // $("#form_pay").append( button )
            

        }
        // */
    },
    methods: {
    },
    computed: {
    }
}
</script>

<style>

</style>
