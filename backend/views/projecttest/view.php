<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Project */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->Id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->Id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Id',
            'NoProject',
            'ProjectAt',
            'Name:ntext',
            'PaymentTerm:ntext',
            'PI_At',
            'PI_By',
            'DP_At',
            'DP_By',
            'QC_At',
            'QC_By',
            'BAST_At',
            'BAST_By',
            'Status',
            'UpdatePermission',
            'StartDate',
            'EndDate',
            'Duration',
            'CreatedAt',
            'CreatedBy',
        ],
    ]) ?>

</div>
