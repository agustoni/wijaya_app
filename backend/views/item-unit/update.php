<?php

use yii\helpers\Html;

$this->title = 'Update Item Unit: #' . $model->Id;
?>
<div class="item-unit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
