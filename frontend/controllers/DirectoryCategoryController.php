<?php

namespace frontend\controllers;

use common\models\DirectoryCategory;
use common\models\DirectoryList;
use common\models\search\DirectoryCategorySearch;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\AuthValidator;

/**
 * DirectoryCategoryController implements the CRUD actions for DirectoryCategory model.
 */
class DirectoryCategoryController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'delete-directory' => ['POST'],
                        'delete-all' => ['POST'],
                    ],
                ],
                /*'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'view'],
                            'roles' => ['view'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['create-directory'],
                            'roles' => ['create'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['import-data', 'test'],
                            'roles' => ['admin'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['update'],
                            'roles' => ['update'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['delete'],
                            'roles' => ['delete'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['delete-all', 'create'],
                            'roles' => ['admin', 'delete'],
                        ]
                    ],
                ],*/
            ]
        );
    }

    /**
     * Lists all DirectoryCategory models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DirectoryCategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTest()
    {
        DirectoryCategory::deleteAll();
        $db = Yii::$app->db2;
        $query = (new Query())->select(['*'])
            ->from('directory_category')
            ->all($db);

        foreach ($query as $row) {
            $check = DirectoryCategory::findOne(['id' => $row['id']]);
            if ($check) continue;
            $ctg = new DirectoryCategory();
            $ctg->id = $row['id'];
            $ctg->name_ru = $row['name_ru'];
            $ctg->name_uzkyrl = $row['name_uzkyrl'];
            $ctg->name_uzlat = $row['name_uzlat'];
            if ($ctg->save()) {
                $dir = (new Query())->select(['*'])
                    ->from('directory_list')
                    ->where(['category_id' => $row['id']])
                    ->all($db);
                foreach ($dir as $item) {
                    $new_dir = (new Query())->select(['*'])
                        ->from('directory_list')
                        ->where(['category_id' => $ctg->id])
                        ->all($db);
                    $new_dir = new \common\models\DirectoryList();
                    $new_dir->id = $item['id'];
                    $new_dir->name_ru = $item['name_ru'];
                    $new_dir->name_uzkyrl = $item['name_uzkyrl'];
                    $new_dir->name_uzlat = $item['name_uzlat'];
                    $new_dir->type = $item['type'];
                    $new_dir->class_name = $item['class_name'];
                    $new_dir->class_id = $item['class_id'];
                    $new_dir->category_id = $item['category_id'];
                    $new_dir->save();
                }

            } else {
                continue;
            }
        }

    }

    /**
     * Displays a single DirectoryCategory model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $lang = Yii::$app->language;
        $searchModel = new \common\models\search\DirectoryListSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['category_id' => $id]);
        $dataProvider->query->orderBy(["name_$lang" => SORT_ASC]);
        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new DirectoryCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DirectoryCategory();
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateDirectory()
    {
        $model = new DirectoryList();
        if ($model->load($this->request->post())) {
            $model->type = $model->category_id;
            $model->save();
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * Updates an existing DirectoryCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DirectoryCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteDirectory($id)
    {
        $m = \common\models\DirectoryList::findOne($id);
        $m->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeleteAll($id)
    {
        \common\models\DirectoryList::deleteAll(['category_id' => $id]);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the DirectoryCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DirectoryCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DirectoryCategory::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionImportData()
    {
        // lang 1 = Uzlat; lang 2 = Ru; lang 3 = uzkyrl;
        if ($this->request->isPost) {
            $post = $this->request->post();
            $url = $post['import_url'];
            $limit = $post['limit'];
            $langs = [1, 2, 3];
            $attr_name = $post['attr_name'];
            $attr_id = $post['attr_id'];
            $category_id = $post['category_id']; // Категория для сохранения
            $data = []; // Инициализируем массив данных

            foreach ($langs as $lang) {
                $parse = $this->parseUrl($url, $limit, $lang);
                $client = new Client();
                $response = $client->createRequest()
                    ->setMethod('GET')
                    ->setUrl($parse['url'])
                    ->send();

                $response_data = $response->data['result']['data'] ?? [];

                foreach ($response_data as $item) {
                    // Получаем идентификатор записи
                    $id = $item[$attr_id] ?? null;
                    if (!$id) {
                        continue; // Пропускаем, если идентификатор отсутствует
                    }

                    // Инициализация записи в массиве данных
                    if (!isset($data[$id])) {
                        $data[$id] = [
                            'class_id' => $id,
                            'class_name' => $parse['name'],
                            'name_uzlat' => null,
                            'name_ru' => null,
                            'name_uzkyrl' => null,
                        ];
                    }

                    // Добавляем данные для соответствующего языка
                    $value = $item[$attr_name] ?? null;
                    if ($lang == 1) {
                        $data[$id]['name_uzlat'] = $value;
                    } elseif ($lang == 2) {
                        $data[$id]['name_ru'] = $value;
                    } elseif ($lang == 3) {
                        $data[$id]['name_uzkyrl'] = $value;
                    }
                }
            }

            array_values($data);
            // Сохранение данных в базу
            foreach ($data as $item) {
                $check = DirectoryList::findOne([
                    'name_ru' => $item['name_ru'],
                    'name_uzkyrl' => $item['name_uzkyrl'],
                    'name_uzlat' => $item['name_uzlat'],
                ]);

                // Пропускаем, если запись уже существует
                if ($check) {
                    continue;
                }

                // Создаём новую запись
                $model = new \common\models\DirectoryList();
                $model->category_id = $category_id;
                $model->name_ru = $item['name_ru'];
                $model->name_uzkyrl = $item['name_uzkyrl'];
                $model->name_uzlat = $item['name_uzlat'];
                $model->class_name = $item['class_name'];
                $model->class_id = $item['class_id'];
                $model->type = $item['class_id'];

                // Сохраняем запись и обрабатываем ошибки
                if (!$model->save()) {
                    Yii::error('Ошибка сохранения: ' . json_encode($model->errors));
                }
            }

            // Перенаправляем обратно
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    protected function parseUrl($url, $limit, $lang)
    {
        $req_url = 'https://cs.egov.uz';
        // Разбираем URL на части
        $urlParts = parse_url($url);

        // Парсим строку запроса в массив
        parse_str($urlParts['query'], $params);

        // Изменяем параметры
        $params['limit'] = !empty($limit) ? $limit : 100; // Новое значение для limit
        $params['lang'] = $lang;  // Новое значение для lang

        // Формируем новую строку запроса
        $urlParts['query'] = http_build_query($params);

        // Составляем новый URL
        $newUrl = $req_url . (isset($urlParts['scheme']) ? $urlParts['scheme'] . '://' : '') .
            (isset($urlParts['host']) ? $urlParts['host'] : '') .
            (isset($urlParts['path']) ? $urlParts['path'] : '') .
            '?' . $urlParts['query'];
        return ['name' => $params['name'], 'url' => $newUrl];

    }
}
