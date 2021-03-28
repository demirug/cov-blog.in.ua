<?php
    //Short route to main page can't contain arguments
    return [
        '' => [
            'controller' => 'Main',
            'action' => 'index'
        ],

        'contact' => [
            'controller' => 'Main',
            'action' => 'contact'
        ],

        'login' => [
            'controller' => 'Account',
            'action' => 'login'
        ],

        'register' => [
            'controller' => 'Account',
            'action' => 'register'
        ],

        'logout' => [
            'controller' => 'Account',
            'action' => 'logout'
        ],

        'blog' => [
            'controller' => 'Blog',
            'action' => 'index'
        ]

    ];
