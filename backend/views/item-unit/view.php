<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->Id;
\yii\web\YiiAsset::register($this);
?>
<div class="item-unit-view">

    <h1>#<?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Id',
            'UoM',
        ],
    ]) ?>

</div>
