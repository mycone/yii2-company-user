<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use mycone\users\models\Depts;
use yii\helpers\ArrayHelper;
use kartik\tree\TreeViewInput;

/* @var $this yii\web\View */
/* @var $model mycone\users\models\Employees */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employees-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal']); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true])->hint('由字母、数字、下划线组成') ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'depts_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'depts_id')->widget(TreeViewInput::className(),[
    'name' => 'kvTreeInput',
    //'value' => 'false', // preselected values
    'query' => Depts::find()->addOrderBy('root, lft'),
    'headingOptions' => ['label' => '组织架构'],
    'rootOptions' => ['label'=>'<i class="fa fa-tree text-success"></i>'],
    //'fontAwesome' => true,
    'asDropdown' => true,
    'multiple' => false,
    'options' => ['disabled' => false]
]) ?>
    
    <?= $form->field($model, 'jobs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telphone')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'idcard')->textInput(['maxlength' => 18]) ?>
    
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    
    <?//= $form->field($model, 'last_at')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'last_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList($model->statusArray,['prompt'=>'请选择']) ?>

    <?= $form->field($model, 'avatar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>

    <?//= $form->field($model, 'created_at')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
