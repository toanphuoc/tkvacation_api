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
                // array('<controller>/<action>/<currenetPage:\d+>', 'pattern' => '<controller:\w+>/<action:\w+>/<currenetPage:\d+>', 'verb' => 'GET'),
                // array('<controller>/<action>/<id:\d+>', 'pattern'=>'<controller:\w+>/<action:\w+>/<id:\d+>', 'verb'=>'GET'),

                //API for Contact
                array('contact/create', 'pattern' => 'contact/create', 'verb' => 'POST'),

                //API for Customize Tour
                array('customizetour/create', 'pattern' => 'customizetour/create', 'verb' => 'POST'),

                //API for booking
                array('booking/create', 'pattern' => 'booking/create', 'verd' => 'POST'),
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            )
        ),
    ),
);