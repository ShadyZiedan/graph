<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vertices */

$this->title = 'Create Vertices';
$this->params['breadcrumbs'][] = ['label' => 'Vertices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vertices-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
