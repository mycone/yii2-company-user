<?php

namespace mycone\users\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use mycone\users\models\EmployeesData;
use mycone\users\models\Depts;

/**
 * Default controller for the `users` module
 */
class DefaultController extends Controller
{
    /**
     * 关闭CSRF验证
     * @var boolean
     */
    public $enableCsrfValidation = false;
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['POST'],
                    'depts' => ['GET'],
                ],
            ],
        ];
    }
    
    /**
     * 初始化
     * @see \yii\base\Object::init()
     */
    public function init() {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;
    }
    
    /**
     * 根据帐号、密码获取员工信息
     * @return string
     */
    public function actionIndex()
    {
        $employeesData = new EmployeesData();
        if($employeesData->load(Yii::$app->request->post(),'') && $employeesData->validate()) {
            return ['name'=>'Request Success','message'=>'请求成功','code'=>1,'status'=>200,'data'=>$employeesData->getData()];
        }
        if ($employeesData->hasErrors()) {
            return ['name'=>'Request False','message'=>array_values($employeesData->getFirstErrors())[0],'code'=>0,'status'=>400,'data'=>''];
        }
        return ['name'=>'Request False','message'=>'Request False','code'=>0,'status'=>400,'data'=>''];
    }
    
    /**
     * 获取部门信息
     */
    public function actionDepts() {
        return Depts::list_to_tree();
    }
    
}
