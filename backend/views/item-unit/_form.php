<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemUnit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-unit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'UoM')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
