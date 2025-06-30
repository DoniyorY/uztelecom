<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'name' => 'SIMMA ECO-SYSTEM',
    //'defaultRoute' => 'velzon/index',
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'mobile' => [
            'class' => 'frontend\modules\mobile\Mobile',
        ],
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap5\BootstrapAsset' => [
                    'css' => []
                ],
                'yii\bootstrap5\BootstrapPluginAsset' => [
                    'js' => []
                ],
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
                /*'yii\web\JqueryAsset' => [
                    'js' => []
                ],*/
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'], // Можно: error, warning, trace и т.д.
                    'categories' => ['api'], // <— категория, по которой будешь писать
                    'logFile' => '@app/runtime/logs/api.log', // <— твой лог-файл
                    'maxFileSize' => 1024, // в KB
                    'maxLogFiles' => 5,
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                /*
                '' => 'site/index',
                //'login' => 'site/login',
                'tasks' => 'task/index',
                'my-tasks' => 'task/my-tasks',
                'task-new' => 'task/create',
                'task/detail/<id>' => 'task/view',
                'task/status/<token>-<status>-<position>' => 'task/status',
                'regions' => 'region/index',

                'status-lists' => 'status-list/index',
                'status-list-update-<id>' => 'status-list/update',
                'status-list-delete-<id>' => 'status-list/delete',

                'departments' => 'department/index',
                'departments-update-<id>' => 'department/update',
                //'departments-delete-<id>' => 'department/delete',

                'positions' => 'position/index',
                'position-update-<id>' => 'position/update',
                'position-delete-<id>' => 'position/delete',


                '/velzon/<action>' => '/velzon/root'
                */
            ],
        ],
        'as access' => [
            'class' => yii\filters\AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['login'], // Доступ разрешен только к странице login
                    'roles' => ['?'],       // Только для гостей
                ],
                [
                    'allow' => true,
                    'roles' => ['@'],       // Только для авторизованных пользователей
                ],
            ],
            'denyCallback' => function ($rule, $action) {
                return Yii::$app->response->redirect(['site/login']);
            },
        ],
    ],
    'params' => $params,
];
