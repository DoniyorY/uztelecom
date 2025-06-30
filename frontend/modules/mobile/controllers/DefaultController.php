<?php

namespace frontend\modules\mobile\controllers;

use yii\web\Controller;
use yii\web\HttpException;

/**
 * Default controller for the `mobile` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public static function getPost($ps = array())
    {
        $post = \Yii::$app->request->getBodyParams();
        if (!$post) {
            throw new HttpException(400, 'Параметры не переданы');
        }
        if ($ps) {
            foreach ($ps as $value) {
                if ($value && !array_key_exists($value, $post) || !$post[$value]) {
                    throw new HttpException(400, 'переданы не все параметры / ' . $value);
                }
            }
        }
        return $post;
    }
}
