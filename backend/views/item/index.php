<?php 
    use yii\grid\GridView;
    use yii\widgets\Pjax;
	
    $this->title = "Item Master";
	// $this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
	// $this->params['breadcrumbs'][] = $this->title;
	\yii\web\YiiAsset::register($this);
?>
<div class="item-wrapper">
	<div class="row my-2">
		<div class="col-md-3">
			<h2>Item Master</h2>
		</div>
		<div class="col-md-9 text-right">
			<a  class="btn btn-success ml-2" target="_blank" href="<?= yii::$app->urlManager->createUrl(['item/create-item']); ?>">
                Buat Item
            </a>
            <a  class="btn btn-primary ml-2" target="_blank" href="<?= yii::$app->urlManager->createUrl(['item/create-item-combined']); ?>">
                Buat Item Kombinasi
            </a>
		</div>
	</div>
	
    <?php Pjax::begin(['id'=>'pjax-po']); ?>
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
                'format' => 'raw',
            ],
            [
                'attribute' => 'IdUoM',
                'value' => function($model){
                    return $model->itemUnit__r->UoM;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'Description',
                'value' => function($model){
                    return $model->Description? $model->Description : '-';
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'Type',
                'value' => function($model){
                    if($model->Type == 1){
                        return "Siap Pakai";
                    }else if($model->Type == 2){
                        return "Kombinasi";
                    }else if($model->Type == 3){
                        return "Jasa";
                    }else if($model->Type == 4){
                        return "Part";
                    }
                },
                'format' => 'raw',
                'filter' => [1 => 'Siap Pakai', 2 => 'Kombinasi', 3 => 'Jasa', 4 => 'Part']
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
                            <a class="dropdown-item" href="'.Yii::$app->urlManager->createUrl(['/item/view', 'id' => $model->Id]).'" data-pjax=0 target="_blank">
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