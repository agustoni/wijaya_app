<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchase Orders';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/web/js/page_script/purchase_order/index.js',['depends' => [\yii\web\JqueryAsset::class]]);
?>
<div class="purchase-order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Buat PO', ['create'], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
            	'attribute' => 'ReceivedAt',
            	'value' => function($model){
            		if($model->ReceivedAt){
            			return '<i class="fas fa-circle fa-1x text-success"></i><br>'.date('d-m-Y H:i', strtotime($model->ReceivedAt))."<br>".$model->receivedBy__r->username;
            		}else{
            			return '<i class="fas fa-circle fa-1x text-danger"></i>';
            		}
            	},
            	'filter' => [0 => 'Tidak', 1 => 'Iya'],
            	'format' => 'raw',
            	'contentOptions' => ['class' => 'text-center', "style" => "width:15%"],
            ],
            [
            	'attribute' => 'ApprovedAt',
            	'value' => function($model){
            		if($model->ApprovedAt){
            			return '<i class="fas fa-circle fa-1x text-success"></i><br>'.date('d-m-Y H:i', strtotime($model->ApprovedAt))."<br>".$model->approvedBy__r->username;
            		}else{
            			return '<i class="fas fa-circle fa-1x text-danger"></i>';
            		}
            	},
            	'format' => 'raw',
            	'filter' => [0 => 'Tidak', 1 => 'Iya'],
            	'contentOptions' => ['class' => 'text-center', "style" => "width:15%"],
            ],

            [
            	'class' => 'yii\grid\ActionColumn',
            	'header' => 'Action',
                'template' => '{action}',
                'buttons' => [
                	'action' => function($url, $model){
                        $actionBtn = '<a class="dropdown-item" href="'.Yii::$app->urlManager->createUrl(['/purchase-order/update', 'id' => $model->Id]).'" data-pjax=0 target="_blank">Update/Lihat</a>';

                        if(!$model->ApprovedAt){
                            $actionBtn .= '
                                <a class="dropdown-item btn-approved" href="#" data-toggle="modal" data-idpo="'.$model->Id.'">Setuju</a>';
                        }

                        if($model->ApprovedAt && !$model->ReceivedAt){
                            $actionBtn .= '<a class="dropdown-item btn-received" href="#" data-toggle="modal" data-idpo="'.$model->Id.'">Diterima</a>';
                        }

                        $actionBtn .= '<a class="dropdown-item btn-print" href="#" data-toggle="modal" data-idpo="'.$model->Id.'">Print</a>';

                        return '
                        <button class="btn btn-sm btn-outline-info dropdown-toggle" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Options
                        </button>
                        <div class="dropdown-menu">'.$actionBtn.'</div>';
                	}
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>