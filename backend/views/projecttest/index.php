<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'NoProject',
            'ProjectAt',
            'Name:ntext',
            'PaymentTerm:ntext',
            //'PI_At',
            //'PI_By',
            //'DP_At',
            //'DP_By',
            //'QC_At',
            //'QC_By',
            //'BAST_At',
            //'BAST_By',
            //'Status',
            //'UpdatePermission',
            //'StartDate',
            //'EndDate',
            //'Duration',
            //'CreatedAt',
            //'CreatedBy',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action',
                'template' => '{action}',
                'buttons' => [
                    'action' => function($url, $model){
                        return '
                        <button class="btn btn-sm btn-outline-info dropdown-toggle" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Options
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="'.Yii::$app->urlManager->createUrl(['/purchase-order/view', 'id' => $model->Id]).'" data-pjax=0 target="_blank">
                                Lihat
                            </a>
                            <a class="dropdown-item" href="'.Yii::$app->urlManager->createUrl(['/purchase-order/update', 'id' => $model->Id]).'" data-pjax=0 target="_blank">
                                View
                            </a>
                        </div>';
                    }
                ]
            ],
        ],
        'pager' => [
            'class' => '\yii\bootstrap4\LinkPager'
        ]
    ]); ?>

    <?php Pjax::end(); ?>

</div>
