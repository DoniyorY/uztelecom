<?php

namespace frontend\controllers;

use common\models\Company;
use common\models\RegistryDocument;
use common\models\search\RegistryDocumentSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\db\Query;
use common\models\Employees;
use common\models\Department;

class DocumentsController extends Controller
{

    public function actionRegistry($company_id)
    {
        $searchModel = new RegistryDocumentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];
        $query = $dataProvider->query;
        $query->andWhere(['company_id' => $company_id]);
        $company = Company::findOne($company_id);

        return $this->render('registry_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'company' => $company
        ]);
    }

    public function actionEmployeeList($company_id, $gender = null)
    {
        $query = (new Query())
            ->select([
                'e.id',
                'e.fullname',
                'gender_dir.name_ru AS gender',
                'e.passport_series',
                'e.passport_whois',
                'p.name AS position',
                'e.address',
                'nat_dir.name_ru AS nationality',
                'e.birthday',
                'p.company_id',
                'dep.name AS department_name',
            ])
            ->from(['e' => 'employees'])
            ->leftJoin(['u' => 'user'], 'e.user_id = u.id')
            ->leftJoin(['p' => 'position'], 'u.position_id = p.id')
            ->leftJoin(['nat_dir' => 'directory_list'], 'e.nationality = nat_dir.id')
            ->leftJoin(['gender_dir' => 'directory_list'], 'e.sex = gender_dir.id')
            ->leftJoin(['dep' => 'department'], 'p.department_id = dep.id')
            ->andWhere(['p.company_id' => $company_id])
            ->orderBy(['e.fullname' => SORT_ASC]);
        if ($gender === 'male') $query->andWhere(['e.sex' => 506]);
        if ($gender === 'female') $query->andWhere(['e.sex' => 507]);
        $data = $query->all();
        $arr = ArrayHelper::index($data, null, 'department_name');
        $company = Company::findOne($company_id);
        // echo "<pre>";
        // print_r($arr);
        // die();
        return $this->render('employee_list', [
            'query' => $arr,
            'company' => $company
        ]);
    }

    public function actionEmployeeChildren($company_id)
    {
        $query = (new Query())
            ->select([
                'ch.fullname',
                'ch.birthday',
                'e.fullname as parent_name',
                'e.id as parent_id'
            ])
            ->from(['ch' => 'employees_children'])
            ->leftJoin(['e' => 'employees'], 'ch.employee_id = e.id')
            ->leftJoin(['u' => 'user'], 'e.user_id = u.id')
            ->leftJoin(['p' => 'position'], 'u.position_id = p.id')
            ->andWhere(['p.company_id' => $company_id]);

        $data = ArrayHelper::index($query->all(), null, 'parent_name');

        foreach ($data as &$childrenList) {
            foreach ($childrenList as &$child) {
                $birthDate = (new \DateTime())->setTimestamp($child['birthday']);
                $now = new \DateTime();
                $child['child_age'] = $birthDate->diff($now)->y;
            }
        }
        $company = Company::findOne($company_id);
        return $this->render('employee_children', [
            'children' => $data,
            'company' => $company
        ]);
    }

    public function actionStaffingSchedule($company_id)
    {
        $department_list = Department::find()->all();
        $company = Company::findOne($company_id);
        return $this->render('staffing_schedule_view', [
            'department_list' => $department_list,
            'company' => $company
        ]);
    }

    public function actionStaffingList($company_id)
    {
        $department_list = Department::find()->all();
        $company = Company::findOne($company_id);
        return $this->render('staffing_list_view', [
            'department_list' => $department_list,
            'company' => $company
        ]);
    }

    public function actionDocT2($employee_id)
    {
        $model = Employees::findOne($employee_id);
        return $this->render('doc_t2', [
            'model' => $model
        ]);
    }
}