<?php 
    use yii\widgets\Pjax;
    use yii\grid\GridView;

	$this->title = "Supplier Master";
?>
<div class="item-wrapper">
	<div class="row my-2">
		<div class="col-md-3">
			<h2>Supplier Master</h2>
		</div>
		<div class="col-md-9 text-right">
			<a type="button" class="btn btn-success ml-2" target="_blank" href="<?= yii::$app->urlManager->createUrl(['supplier/create']) ?>">
                New Supplier
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
                'attribute' => 'Name',
                'value' => function($model){
                    return $model->Name;
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'Address',
                'value' => function($model){
                    return $model->Address? $model->Address : '-';
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'Phone',
                'value' => function($model){
                    return $model->Phone? $model->Phone : '-';
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'Description',
                'value' => function($model){
                    return $model->Description? $model->Description : '-';
                },
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
                            <a class="dropdown-item" href="'.Yii::$app->urlManager->createUrl(['/supplier/view', 'id' => $model->Id]).'" data-pjax=0 target="_blank">
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