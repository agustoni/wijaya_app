<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'NoProject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'PaymentTerm')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'PI_At')->textInput() ?>

    <?= $form->field($model, 'PI_By')->textInput() ?>

    <?= $form->field($model, 'DP_At')->textInput() ?>

    <?= $form->field($model, 'DP_By')->textInput() ?>

    <?= $form->field($model, 'QC_At')->textInput() ?>

    <?= $form->field($model, 'QC_By')->textInput() ?>

    <?= $form->field($model, 'BAST_At')->textInput() ?>

    <?= $form->field($model, 'BAST_By')->textInput() ?>

    <?= $form->field($model, 'Status')->textInput() ?>

    <?= $form->field($model, 'UpdatePermission')->textInput() ?>

    <?= $form->field($model, 'StartDate')->textInput() ?>

    <?= $form->field($model, 'EndDate')->textInput() ?>

    <?= $form->field($model, 'Duration')->textInput() ?>

    <?= $form->field($model, 'CreatedAt')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
