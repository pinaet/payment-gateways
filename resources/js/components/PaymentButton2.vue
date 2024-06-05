<template>  

                                <!-- <button id="paynow" class="btn btn--radius btn--harrow" type="submit">Pay Now</button> -->
                                <form id="form_pay2" method="POST" action="https://dev-kpaymentgateway-services.kasikornbank.com/KPGW-Redirect-Webapi/Alipay/redr_test_12345_00068_125">
                                    <script type="application/javascript" 
                                    src="https://dev-kpaymentgateway.kasikornbank.com/ui/v2/kpayment.min.js" 
                                    data-apikey="pkey_test_683yajTS8Owc9Tt1xxaHlm7DvUZ7LmKt4F"
                                    data-amount="1" 
                                    data-payment-methods="alipay"> 
                                    </script>
                                </form>

</template>

<script>
export default {
    data() {
        return {
            order: '',
            sourceType: '',
        }
    },
    props: [ 'orderRaw', 'sourceTypeRaw' ],
    mounted() {
        this.order       = JSON.parse( this.orderRaw      )
        this.sourceType  = JSON.parse( this.sourceTypeRaw )

        //generate pay button
        
        // var script  = '\
        //                 <script type="text/javascript" \
        //                 src="https://dev-kpaymentgateway.kasikornbank.com/ui/v2/kpayment.min.js" \
        //                 data-apikey="pkey_test_683yajTS8Owc9Tt1xxaHlm7DvUZ7LmKt4F" \
        //                 data-amount="1" data-payment-methods="wechat" data-order-id="order_test_68661d642a38b84a898b20775a5ec0420e">'        
        //     script += '<'
        //     script += '/script>'
        // var form    = $( '<form id="payForm" method="POST" action="https://dev-kpaymentgateway-services.kasikornbank.com/KPGW-Redirect-Webapi/UPOP/redr_test_3e0fd45c342d4291baba1586bcfd80ec"></form>' )
        // $("#pay_button").append( form );
        // $("#payForm").append( script );
        // form.append( script )
    },
    methods: {
    },
    computed: {
    }
}
</script>

<style>

</style>
