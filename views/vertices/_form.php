<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Vertices */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vertices-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'graph_id')->textInput() ?>

    <?= $form->field($model, 'x')->textInput() ?>

    <?= $form->field($model, 'y')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
