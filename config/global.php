<?php

return [
    'restApi' => [
        'baseUrl' => 'http://192.168.1.13:3000',
        'customers' => [
            'list' => '/api/customers/list',
            'getbyid' => '/api/customers/getbyid/',
            'getbycode' => '/api/customers/getbycode/',
            'getemptymodel' => '/api/customers/getemptymodel',
            'getdivisions' => '/api/customers/getdivisions',
            'getdivisiongroups' => '/api/customers/getdivisiongroups?DivisionId=',
            'save' => '/api/customers/save',
        ],
    ]
];
