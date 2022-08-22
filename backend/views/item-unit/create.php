<?php

use yii\helpers\Html;
$this->title = 'Buat Item Unit';
?>
<div class="item-unit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
