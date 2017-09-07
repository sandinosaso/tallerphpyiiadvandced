<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),  
    'controllerNamespace' => 'api\controllers',  
    'bootstrap' => ['log'],
    'modules' => [
         
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
            //'loginUrl' => null,
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8'
        ],
       
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
       
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                    // CRUD Controllers
                    'HEAD <apiv:v\d+>/<controller:\w+>'              => '<apiv>/<controller>/index',
                    'GET <apiv:v\d+>/<controller:\w+>'               => '<apiv>/<controller>/index',
                    'HEAD <apiv:v\d+>/<controller:\w+>/<id:(\d)+>'   => '<apiv>/<controller>/view',
                    'GET <apiv:v\d+>/<controller:\w+>/<id:(\d)+>'    => '<apiv>/<controller>/view',
                    'POST <apiv:v\d+>/<controller:\w+>'              => '<apiv>/<controller>/create', 
                    'PUT <apiv:v\d+>/<controller:\w+>/<id:(\d)+>'    => '<apiv>/<controller>/update',
                    'PATCH <apiv:v\d+>/<controller:\w+>/<id:(\d)+>'  => '<apiv>/<controller>/update',
                    'DELETE <apiv:v\d+>/<controller:\w+>/<id:(\d)+>' => '<apiv>/<controller>/delete',  

                    //Reglas genericas para otras Actions
                    'GET <apiv:v\d+>/<controller:\w+>/<action:\w+>' => '<apiv>/<controller>/<action>',
                    'POST <apiv:v\d+>/<controller:\w+>/<action:\w+>' => '<apiv>/<controller>/<action>',
                    
            ]       
        ],
    ],
    'params' => $params,
];



