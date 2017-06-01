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
                array('<controller>/<action>/<id:\d+>', 'pattern'=>'<controller:\w+>/<action:\w+>/<id:\d+>', 'verb'=>'GET'),
                // array('<controller>/<action>/<id:\d+>', 'pattern'=>'<controller:\w+>/<action:\w+>/<id:\d+>', 'verb'=>'GET'),
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            )
        ),
    ),
);