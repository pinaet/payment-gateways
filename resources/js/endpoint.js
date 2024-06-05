require('./bootstrap');

import Vue from 'vue'

new Vue({
    el: '#app',
    props: [
        'endpoint_id',
        'amount',
        'currency',
        'description',
        'reference_order',
    ],
    components: {
    },
    mounted() {
    },
    methods: {
        postIt() {
            $('#orderForm').attr('action', './order')
            $('#orderForm').attr('method', 'post')
            $('#orderForm').submit()
        }
    }
})

