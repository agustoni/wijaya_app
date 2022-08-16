<?php 
    use yii\widgets\Pjax;
    use yii\grid\GridView;

	$this->title = "Product Master";
?>
<div class="item-wrapper">
	<div class="row my-2">
		<div class="col-md-3">
			<h2>Product Master</h2>
		</div>
		<div class="col-md-9 text-right">
			<a  class="btn btn-success ml-2" target="_blank" href="<?= yii::$app->urlManager->createUrl(['product/create']); ?>">
                New Item
            </a>
		</div>
	</div>
	
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'IdType',
                'value' => function($model){
                    return $model->IdType? $model->IdType : '-';
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'Name',
                'value' => function($model){
                    return $model->Name? $model->Name : '-';
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'Status',
                'value' => function($model){
                    return $model->Status == 1? 'Aktif' : '<span class="text-danger">Tidak Aktif</span>';
                },
                'filter' => [0 => 'Tidak Aktif', 1 => 'Aktif'],
                'format' => 'raw'
            ],

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
                            <a class="dropdown-item" href="'.Yii::$app->urlManager->createUrl(['/product/view', 'id' => $model->Id]).'" data-pjax=0 target="_blank">
                                Lihat
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