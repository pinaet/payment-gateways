<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Write some description here
    |
    */
    'mode'              => env('GATE_MODE', 'gate-dev'),

    'gate-prod'         => [
        'base_url'      => env('GATE_BASE_URL'  , 'https://applications.harrowschool.ac.th/payment/public'          ),
        'kbank'         => [
            'src'       => env('GATE_KBANK_SRC' , 'https://kpaymentgateway.kasikornbank.com/ui/v2/kpayment.min.js'  ),
        ],
        'tbank'         => [
            'gate'      => env('GATE_TBANK_GATE', 'https://applications.harrowschool.ac.th/paymentgateway/index.php'),
        ],
        'url'           => env('GATE_URL'       , 'https://applications.harrowschool.ac.th/gate/public'             ),
    ],

    'gate-dev'          => [
        'base_url'      => 'https://histest.harrowschool.ac.th/payment/public',
        'kbank'         => [
            'src'       => 'https://dev-kpaymentgateway.kasikornbank.com/ui/v2/kpayment.min.js',
        ],
        'tbank'         => [
            'gate'      => 'https://histest.harrowschool.ac.th/payment/public/ttb/2c2p/card/create',
        ],
        'url'           => 'https://histest.harrowschool.ac.th/gate/public',
    ],

    'alipay'            => [
        'url'           => '/kbank/alipay',
        'create'        => '/kbank/alipay/create',
        'store'         => '/kbank/alipay/store',
    ],
    'card'              => [
        'url'           => '/card/create',
    ],
    'unionpay'          => [
        'url'           => '/kbank/tpn-union',
        'create'        => '/kbank/tpn-union/create',
        'store'         => '/kbank/tpn-union/store',
    ],
    'wechat'            => [
        'url'           => '/kbank/wechat',
        'create'        => '/kbank/wechat/create',
        'store'         => '/kbank/wechat/store',
        'callback'      => '/kbank/wechat/callback',
        'check'         => '/kbank/wechat/check',
        'remove'        => '/kbank/wechat/remove',
    ],

];
