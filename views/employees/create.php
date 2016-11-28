<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model mycone\users\models\Employees */

$this->title = '添加员工';
$this->params['breadcrumbs'][] = ['label' => '员工管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employees-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
