<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProjectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'Id') ?>

    <?= $form->field($model, 'NoProject') ?>

    <?= $form->field($model, 'ProjectAt') ?>

    <?= $form->field($model, 'Name') ?>

    <?= $form->field($model, 'PaymentTerm') ?>

    <?php // echo $form->field($model, 'PI_At') ?>

    <?php // echo $form->field($model, 'PI_By') ?>

    <?php // echo $form->field($model, 'DP_At') ?>

    <?php // echo $form->field($model, 'DP_By') ?>

    <?php // echo $form->field($model, 'QC_At') ?>

    <?php // echo $form->field($model, 'QC_By') ?>

    <?php // echo $form->field($model, 'BAST_At') ?>

    <?php // echo $form->field($model, 'BAST_By') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'UpdatePermission') ?>

    <?php // echo $form->field($model, 'StartDate') ?>

    <?php // echo $form->field($model, 'EndDate') ?>

    <?php // echo $form->field($model, 'Duration') ?>

    <?php // echo $form->field($model, 'CreatedAt') ?>

    <?php // echo $form->field($model, 'CreatedBy') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
