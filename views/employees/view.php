<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model mycone\users\models\Employees */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '员工管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employees-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确认删除本员工信息吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            //'password_hash',
            'auth_key',
            //'depts_id',
            ['attribute'=>'depts.name','label'=>'所属的部门'],
            'fullname',
            'telphone',
            'idcard',
            'email:email',
            'jobs',
            'last_at',
            'last_ip',
            'status_cn',
            'avatar',
            'remark:ntext',
            ['attribute'=>'created_at','format'=>['date','php:Y-m-d H:i:s']],
        ],
    ]) ?>

</div>
