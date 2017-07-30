<?php

// This is the main Web application configuration. Any writable
// application properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Api Demo',

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
    ),

    // application components
    'components'=>array(
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=tkvacation',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ),

        

        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName' => false,
            'rules'=>array(
                //API for tour
                array('tour/getPopularTour', 'pattern'=>'tour/getPopularTour', 'verb'=>'GET'),
                array('tour/getTourByDestination/<id:\d+>', 'pattern' => 'tour/getTourByDestination/<id:\d+>', 'verb' => 'GET'),
                array('tour/getTourById/<id:\d+>', 'pattern' => 'tour/getTourById/<id:\d+>', 'verb' => 'GET'),
                array('tour/getList/<currenetPage:\d+>', 'pattern' => 'tour/getList/<currenetPage:\d+>', 'verb' => 'GET'),
                array('tour/searchTour?keySearch=<keySearch:\w+>&desId=<desId:\d+>&periodMin=<pMin:\d+>&periodMax=<pMax:\d+>&priceMin=<priceMin:\d+>&priceMax=<priceMax:\d+>', 
                    'pattern' => 'tour/searchTour?keySearch=<keySearch:\w+>&desId=<desId:\d+>&periodMin=<pMin:\d+>&periodMax=<pMax:\d+>&priceMin=<priceMin:\d+>&priceMax=<priceMax:\d+>', 'verb' => 'GET'),

                 //API for destination
                array('destination/list', 'pattern' => 'destination/list', 'verb' => 'GET'),
                array('destination/getOtherDestination/<id:\d+>', 'pattern' => 'destination/getOtherDestination/<id:\d+>', 'verb' => 'GET'),
                array('destination/getPopularDestination', 'pattern' => 'destination/getPopularDestination', 'verb' => 'GET'),
                array('destination/getDestinationById/<id:\d+>', 'pattern' => 'destination/getDestinationById/<id:\d+>', 'verb' => 'GET'),
                array('destination/update', 'pattern' => 'destination/update', 'verb' => 'POST'),

                //API for Contact
                array('contact/create', 'pattern' => 'contact/create', 'verb' => 'POST'),
                array('contact/list?page=<page:\d+>', 'pattern' => 'contact/list?page=<page:\d+>', 'verd' => 'GET'),
                array('contact/updateIsRead', 'pattern' => 'contact/updateIsRead', 'verd' => 'PUT'),

                //API for Customize Tour
                array('customizetour/create', 'pattern' => 'customizetour/create', 'verb' => 'POST'),

                //API for booking
                array('booking/create', 'pattern' => 'booking/create', 'verd' => 'POST'),

                //API for blog
                array('blog/list', 'pattern' => 'blog/list', 'verd' => 'GET'),
                array('blog/other/<id:\d+>', 'pattern' => 'blog/other/<id:\d+>', 'verd' => 'GET'),
                array('blog/getBlog/<id:\d+>', 'pattern' => 'blog/getBlog/<id:\d+>', 'verd' => 'GET'),

                //API for login
                array('user/login', 'pattern' => 'user/login', 'verd' => 'POST'),
                array('user/logout', 'pattern' => 'user/logout', 'verd' => 'POST'),
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            )
        ),
        // 'params'=>array(
        //     'listPerPage'=> 10,
        // ),
    ),
);