<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel mycone\users\models\EmployeesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '员工管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employees-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加员工', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('部门管理', ['depts/index'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            //'password_hash',
            
           
             'fullname',
             'telphone', 
             ['attribute'=>'depts_id','value'=>function($model){
                 return $model->depts->name;
             }],
             'jobs',
            // 'email:email',
            // 'last_at',
            // 'last_ip',
            // 'avatar',
            // 'remark:ntext',
             'auth_key',
             ['attribute'=>'created_at','format'=>['date','php:Y-m-d H:i:s']],
             
             'status_cn',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
