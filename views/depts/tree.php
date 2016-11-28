<?php

use yii\helpers\Html;
use kartik\tree\TreeView;
use mycone\users\models\Depts;

$this->title = '部门管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="depts-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('员工管理', ['employees/index'], ['class' => 'btn btn-success']) ?>
    </p>
    
<?php 
echo TreeView::widget([
    // single query fetch to render the tree
    'query'             => Depts::find()->addOrderBy('root, lft'),
    'headingOptions'    => ['label' => '组织架构'],
    'rootOptions' => ['label'=>'<span class="text-primary">陕西车大爷汽车电子商务有限公司</span>'],
    //'isAdmin'           => true,                       // optional (toggle to enable admin mode)
    'displayValue'      => 1,                           // initial display value
    //'softDelete'      => true,                        // normally not needed to change
    //'cacheSettings'   => ['enableCache' => true]      // normally not needed to change
    //'fontAwesome' => true,
    /*'iconEditSettings'=> [
        'show' => 'list',
        'listData' => [
            'folder' => 'Folder',
            'file' => 'File',
            'mobile' => 'Phone',
            'bell' => 'Bell',
        ]
    ],*/
]);
?>
</div>