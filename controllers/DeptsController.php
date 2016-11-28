<?php

namespace mycone\users\controllers;

use Yii;
use yii\web\Controller;

/**
 * DeptsController implements the CRUD actions for Depts model.
 */
class DeptsController extends Controller
{

    /**
     * Lists all Depts models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('tree');
    }

}
