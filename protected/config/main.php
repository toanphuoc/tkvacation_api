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
    ),
    'urlManager' => array(
        'urlFormat'=>'path',
        'rules' => array(
            array('destination/list', 'pattern' => 'destination/<action:\w+>', 'verb' => 'GET'),
            '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
        ),
    ),

);