<template>  

        <div class="page-wrapper bg-red p-t-30 p-b-30 font-robo">
            <div class="wrapper wrapper--w960">
                <div class="card card-2">
                    <div class="card-heading"><img class="card-img" :src="imgPath"></div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-9"></div>
                        </div>
                        <h2 class="title" style="margin-bottom:30px">{{c_title}}</h2>
                        <div class="sub-title  " style="font-size:20px; font-weight:bold; margin-bottom:5px;">{{c_sub_title}}</div>
                        <div class="sub-title-detail" style="margin-bottom:15px;" v-html="c_sub_title_detail"></div>
                        <table width="100%" v-if="order.status=='c'">
                            <tr>
                                <td class="payment-td-title" width="40%">Name</td>
                                <td class="payment-td-content" width="60%">
                                    <input type="text" readonly class="form-control-plaintext p-0" :value="order.customer_name">
                                </td>
                            </tr>
                            <tr>
                                <td class="payment-td-title">Product Detail</td>
                                <td class="payment-td-content">
                                    <input type="text" readonly class="form-control-plaintext p-0" :value="order.description">
                                </td>
                            </tr>
                            <tr>
                                <td class="payment-td-title">Amount Paid</td>
                                <td class="payment-td-content">
                                    <input type="text" readonly class="form-control-plaintext p-0 red-amount" :value="c_total_amount">
                                </td>
                            </tr>
                            <tr>
                                <td class="payment-td-title">Reference Number</td>
                                <td class="payment-td-content">
                                    <input type="text" readonly class="form-control-plaintext p-0 " :value="order.reference_order">
                                </td>
                            </tr>
                            <tr>
                                <td class="payment-td-title">Payment Method</td>
                                <td class="payment-td-content">
                                    <input type="text" readonly class="form-control-plaintext p-0" :value="sourceType.name">
                                </td>
                            </tr>
                            <tr>
                                <td class="payment-td-title">Payment ID</td>
                                <td class="payment-td-content">
                                    <input type="text" readonly class="form-control-plaintext p-0 " :value="order.transaction_id">
                                </td>
                            </tr>
                            <tr>
                                <td class="payment-td-title">Payment Date</td>
                                <td class="payment-td-content">
                                    <input type="text" readonly class="form-control-plaintext p-0 " :value="order.updated_at + ' ' + timezone">
                                </td>
                            </tr>
                        </table>
                        
                        <div id="div_pay" class="p-t-30" >
                            <form method="get" :action="endpoint.endpoint_url">
                                <button id="paynow" class="btn btn--radius btn--harrow" >Back to {{endpoint.name}}</button>
                            </form>
                        </div>
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
            sourceType: '',
            endpoint: '',
            timezone: '',
        }
    },
    props: [ 'orderRaw', 'sourceTypeRaw', 'endpointRaw', 'timezoneRaw', 'imgPath' ],
    components: {
    },
    mounted() {
        this.order       = JSON.parse( this.orderRaw       )
        this.sourceType  = JSON.parse( this.sourceTypeRaw  )
        this.endpoint    = JSON.parse( this.endpointRaw    )
        this.timezone    = JSON.parse( this.timezoneRaw    )
    },
    methods: {
        numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    },
    computed: {
        c_total_amount() {
            let num = this.numberWithCommas( parseFloat(this.order.total_amount).toFixed(2) )
            return  num + ' ' + this.order.currency
        },
        c_title() {
            var title = ''
            if( this.order.status=='c' ) title = 'Payment Successful'
            else                         title = 'Payment Unsuccessful'
            return title
        },
        c_sub_title() {
            var subTitle = ''
            if( this.order.status=='c' ) subTitle = 'Thank You'
            else                         subTitle = this.sourceType.name + ' declined'
            return subTitle
        },
        c_sub_title_detail() {
            var subTitleDetail = ''
            if( this.order.status=='c' ) subTitleDetail = 'Confirmation email is being sent to <span style="color:#A39163">'+this.order.customer_email+'</span>'
            else                         subTitleDetail = 'Please contact the issuing Bank'
            return subTitleDetail
        }
    },
}
</script>

<style>

</style>
