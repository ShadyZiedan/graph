<?php

namespace app\controllers;

use yii\rest\ActiveController;


/**
 * GraphsController implements the CRUD actions for Graphs model.
 */
class GraphsController extends ActiveController
{
    
    public $modelClass = 'app\models\Graphs';

    public $updateScenario = \yii\base\Model::SCENARIO_DEFAULT;
    
}
