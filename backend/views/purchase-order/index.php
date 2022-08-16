<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->registerCssFile("@web/web/css/jquery-ui.css", ['depends'=> [\yii\bootstrap4\BootstrapAsset::className()]]);
$this->registerJsFile("@web/web/js/jquery-ui.js", ['depends'=> [\yii\bootstrap4\BootstrapAsset::className()]]);
$this->registerJsFile('@web/web/js/page_script/purchase_order/index.js',['depends' => [\yii\web\JqueryAsset::class]]);

$this->title = 'Purchase Orders';

?>
<div class="purchase-order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::beginForm([''], 'get'); ?>
        <div class="row mb-3">
            <div class="col-md-2">
                <input class='form-control datepicker purchase-order-from' value='<?= $from ?>' name="searchpo[from]" placeholder="Dari..." required>
            </div>
            <div class="col-md-2">
                <input class='form-control datepicker purchase-order-to' value='<?= $to ?>' name="searchpo[to]" placeholder="Sampai..." required>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary search-po">Cari</button>
            </div>

            <div class="col-md-2 offset-md-4 text-right">
                <?= Html::a('Buat PO', ['create'], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
            </div>
        </div>
    <? Html::endForm() ?>

    <?php Pjax::begin(['id'=>'pjax-po']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
            	'attribute' => 'PoNumber',
            	'value' => function($model){
            		return "<span class='font-weight-bold'>#PO".$model->PoNumber."</span><br>"
            				.date('d-m-Y H:i', strtotime($model->CreatedAt))
            				."<br><small class='font-weight-bold text-info'>".$model->createdBy__r->username."</small>";
            	},
            	'format' => 'raw',
            	'contentOptions' => ["style" => "width:15%"],
            ],
            [
            	'attribute' => 'IdSupplier',
            	'value' => function($model){
            		return "<a href='".Yii::$app->urlManager->createUrl(['/supplier/view', 'id' => $model->IdSupplier])."' target='_blank' data-pjax='0'>"
            					.$model->supplier__r->Name.
            				"</a>";
            	},
            	'format' => 'raw',
            	'contentOptions' => ["style" => "width:20%"],
            ],
            // number_format($invoice->total_weight,0,"",".")
            [
            	'attribute' => 'Total',
            	'value' => function($model){
            		return "Rp ".number_format($model->Total,0,"",".");
            	},
            	'format' => 'raw',
            	'filter' => false,
            	'contentOptions' => ["style" => "width:20%"],
            ],
            [
                'attribute' => 'ApprovedAt',
                'value' => function($model){
                    if($model->ApprovedAt){
                        return '<i class="fas fa-circle fa-1x text-success"></i><br>'.date('d-m-Y H:i', strtotime($model->ApprovedAt))."<br>".$model->approvedBy__r->username;
                    }else{
                        return '<i class="fas fa-circle fa-1x text-danger btn-approved" style="cursor:pointer" data-idpo="'.$model->Id.'"></i>';
                    }
                },
                'format' => 'raw',
                'filter' => [0 => 'Tidak', 1 => 'Iya'],
                'contentOptions' => ['class' => 'text-center', "style" => "width:15%;vertical-align:middle"],
            ],
            [
            	'attribute' => 'ReceivedAt',
            	'value' => function($model){
            		if($model->ReceivedAt){
            			return '<i class="fas fa-circle fa-1x text-success"></i><br>'.date('d-m-Y H:i', strtotime($model->ReceivedAt))."<br>".$model->receivedBy__r->username;
            		}else{
            			return '<i class="fas fa-circle fa-1x '.($model->ApprovedAt? 'text-danger btn-received' : 'text-warning').'" style="cursor:pointer" data-idpo="'.$model->Id.'"></i>';
            		}
            	},
            	'filter' => [0 => 'Tidak', 1 => 'Iya'],
            	'format' => 'raw',
            	'contentOptions' => ['class' => 'text-center', "style" => "width:15%;vertical-align:middle"],
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
                            <a class="dropdown-item" href="'.Yii::$app->urlManager->createUrl(['/purchase-order/update', 'id' => $model->Id]).'" data-pjax=0 target="_blank">
                                Update/Lihat
                            </a>
                            <a class="dropdown-item" href="'.Yii::$app->urlManager->createUrl(['/purchase-order/print', 'id' => $model->Id]).'" data-pjax=0 target="_blank">
                                Print
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