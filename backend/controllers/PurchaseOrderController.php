<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\db\Query;
use kartik\mpdf\Pdf;

use backend\models\Project;
use backend\models\Item;
use backend\models\ItemStock;
use backend\models\PurchaseOrderSearch;
use backend\models\PurchaseOrder;
use backend\models\PurchaseOrderItem;
use backend\models\SupplierItem;
use backend\models\SupplierItemCost;

class PurchaseOrderController extends Controller{
	public function actionIndex(){
		$from = date("d-m-Y");
		$to = date("d-m-Y");

		if(isset($_GET['searchpo'])){
			$from = $_GET['searchpo']['from'];
			$to = $_GET['searchpo']['to'];
		}

		$searchModel = new PurchaseOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $from, $to);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'from' => $from,
            'to' => $to
        ]);
	}

	public function actionCreate(){
		$model = new PurchaseOrder;
		return $this->render("create", ["model" => $model]);
	}

	public function actionUpdate($id){
		$model = PurchaseOrder::findOne($id);
		$arrPoItem = [];

		foreach($model->poItem__r as $idx => $item){
			$arrPoItem[$idx]['idPoItem'] = $item->Id;
			$arrPoItem[$idx]['idSupplier'] = $item->supplierItem__r->IdSupplier;
			$arrPoItem[$idx]['supplierName'] = $item->supplierItem__r->supplier__r->Name;
			$arrPoItem[$idx]['idSupplierItem'] = $item->IdSupplierItem;
			$arrPoItem[$idx]['itemName'] = $item->supplierItem__r->item__r->Name;
			$arrPoItem[$idx]['uom'] = $item->supplierItem__r->item__r->itemUnit__r->UoM;
			$arrPoItem[$idx]['qty'] = $item->Qty;
			$arrPoItem[$idx]['price'] = $item->Price;
			$arrPoItem[$idx]['total'] = $item->Total;
		}
		
		return $this->render("update", ["model" => $model, 'arrPoItem' => json_encode($arrPoItem)]);
	}

	public function actionGetSalesItem($q, $idSupplier=null){
		$model = new Item;
		$allSalesItem = $model->getSalesItem($q, $idSupplier);

		$data = [];
        foreach ($allSalesItem as $d) {
            $data[] = [
            	'IdItem' => $d['IdItem'], 
            	'IdSupplierItem' => $d['IdSupplierItem'], 
            	'ItemName' => $d['ItemName'], 
            	'UoM' => $d['UoM'], 
            	'Cost' => $d['LastPrice'], 
            	'StatusExp' => $d['StatusExp'], 
            	'LastUpdated' => date('d-m-Y', strtotime($d['LastUpdated']))
            ];
        }

        echo Json::encode($data);
        die;
	}

	public function actionGetSupplierItem(){
		$model = new Item;
		$allSupplierItem = $model->getSupplierItem($_POST['IdItem']);

		$data = [];
		foreach($allSupplierItem as $spl){
			$data[] = [
				'IdSupplierItem' => $spl['IdSupplierItem'], 
				'UoM' => $spl['UoM'],
				'ItemName' => $spl['ItemName'],
				'IdSupplier' => $spl['IdSupplier'], 
				'SupplierName' => $spl['SupplierName'], 
				'Price' => $spl['LastPrice']
			];
		}

		echo Json::encode($data);
        die;
	}

	public function actionSubmitPo(){
		try{
			$transaction = \Yii::$app->db->beginTransaction();

			$dataPoItem = $_POST['dataPoItem'];
			$arrPo = [];
			$arrPoNumber = [];

		// CREATE DATA FOR UPDATE/SAVE PO
			foreach($dataPoItem as $dt){
				if(!isset($arrPo[$dt['idSupplier']])){
					$arrPo[$dt['idSupplier']]['Total'] = 0;
					$arrPo[$dt['idSupplier']]['IdPo'] = $dt['idPo'];
				}

				$arrPo[$dt['idSupplier']]['PoItem'][] = [
					"IdPoItem" => $dt["idPoItem"],
					"IdSupplierItem" => $dt["idSupplierItem"],
					"Qty" => $dt["qty"],
					"Price" => $dt["price"],
					"Total" => $dt["total"]
				];

				$arrPo[$dt['idSupplier']]['Total'] += $dt["total"];
			}
		// END CREATE DATA FOR UPDATE/SAVE PO

		// SAVE/UPDATE PROCESS
			foreach($arrPo as $idSupplier => $po){
				if($po['IdPo']){// UPDATE PO
					$modelPo = PurchaseOrder::findOne($po['IdPo']);
					$modelPo->IdSupplier = $idSupplier;
					$modelPo->Total = $po['Total'];
				}else{// CREATE PO
					$modelPo = new PurchaseOrder;
					$modelPo->IdSupplier = $idSupplier;
					$modelPo->Total = $po['Total'];
					$modelPo->CreatedAt = date('Y-m-d H:i:s');
					$modelPo->CreatedBy = Yii::$app->user->id;
				}

				if(!$modelPo->save()){
					throw new \Exception('Save/Update PO gagal!');
				}

				array_push($arrPoNumber, "#".$modelPo->PoNumber);
				
				// SAVE/UPDATE PO ITEM
				foreach($po['PoItem'] as $item){
					if($item['IdPoItem']){// UPDATE PO ITEM
						$modelPoItem = PurchaseOrderItem::findOne($item['IdPoItem']);
					}else{// CREATE PO ITEM
						$modelPoItem = new PurchaseOrderItem;
					}

					$modelPoItem->IdPo = $modelPo->Id;
					$modelPoItem->IdSupplierItem = $item['IdSupplierItem'];
					$modelPoItem->Qty = $item['Qty'];
					$modelPoItem->Price = $item['Price'];
					$modelPoItem->Total = $item['Total'];

					if(!$modelPoItem->save()){
						throw new \Exception('Save/Update PO item gagal!');
					}
				}
			}	
		// END SAVE/UPDATE PROCESS
			
			$transaction->commit();
			die('{"success":true, "PO":'.json_encode($arrPoNumber).'}');
		}catch (\Exception $e) {
			$transaction->rollBack();
            die('{"success":false, "message":'.$e->getMessage().'}');
        }
	}

	public function actionDeletePoItem(){
		try {
			$transaction = \Yii::$app->db->beginTransaction();

		// DELETE PO ITEM
			$idPoItem = $_POST['idPoItem'];

			$model = PurchaseOrderItem::findOne($idPoItem);
			$model->DeletedAt = date('Y-m-d H:i:s');
			$model->DeletedBy = Yii::$app->user->id;

			if(!$model->save()){
				throw new \Exception('Hapus PO item gagal!');
			}
		// END DELETE PO ITEM

		// UPDATE PO
			$poTotal = 0;
			foreach($model->po__r->poItem__r as $item){
				$poTotal += $item->Total;
			}

			$model->po__r->Total = $poTotal;

			if(!$model->po__r->save()){
				throw new \Exception('Update Total PO gagal!');
			}
		// END UPDATE PO

			$transaction->commit();
			die('{"success":true}');
		}catch (\Exception $e) {
			$transaction->rollBack();
            die('{"success":false, "message":'.$e->getMessage().'}');
        }
	}

	public function actionApprovePo(){
		try{
			$transaction = \Yii::$app->db->beginTransaction();
			$idPo = $_POST['idPo'];

			$model = PurchaseOrder::findOne($idPo);
			$model->ApprovedAt = date('Y-m-d H:i:s');
			$model->ApprovedBy = Yii::$app->user->id;

			if(!$model->save()){
				throw new \Exception('Update Status Approve PO gagal!');
			}

			$transaction->commit();
			die('{"success":true, "PO":"'.$model->PoNumber.'"}');
		}catch (\Exception $e) {
			$transaction->rollBack();
            die('{"success":false, "message":'.$e->getMessage().'}');
        }
	}

	public function actionReceivePo(){
		try{
			$transaction = \Yii::$app->db->beginTransaction();
		
		// UPDATE STATUS PO 
			$idPo = $_POST['idPo'];

			$model = PurchaseOrder::findOne($idPo);
			$model->ReceivedAt = date('Y-m-d H:i:s');
			$model->ReceivedBy = Yii::$app->user->id;

			if(!$model->save()){
				throw new \Exception('Update Status Receive PO gagal!');
			}
		// END UPDATE STATUS PO

			$arrItemStock = [];
			foreach($model->poItem__r as $item){
				// SAVE SUPPLIER ITEM COST/HISTORY ITEM PURCHASE
					$modelSic = new SupplierItemCost;
					$modelSic->IdSupplierItem = $item->IdSupplierItem;
					$modelSic->Price = $item->Price;
					$modelSic->Qty = $item->Qty;
					$modelSic->CreatedAt = date('Y-m-d H:i:s');
					$modelSic->CreatedBy = Yii::$app->user->id;

					if(!$modelSic->save()){
						throw new \Exception('Update Supplier Item Cost gagal!');
					}
				// END SAVE SUPPLIER ITEM COST/HISTORY ITEM PURCHASE

				// UPDATING LAST PRICE ON SUPPLIER ITEM 
					$supplierItem = SupplierItem::find()->where('IdItem = '.$item->supplierItem__r->IdItem.' AND IdSupplier = '.$item->supplierItem__r->IdSupplier)->one();
					$supplierItem->Price = $item->Price;
					$supplierItem->Stock += $item->Qty;
					$supplierItem->LastUpdated = date('Y-m-d H:i:s');

					if(!$supplierItem->save()){
						throw new \Exception('Update Supplier Item gagal!');
					}
				// UPDATING LAST PRICE ON SUPPLIER ITEM 
					
				// CREATE ARRAY FOR UPDATING ITEM STOCK
					if(!isset($arrItemStock[$item->supplierItem__r->IdItem])){
						$arrItemStock[$item->supplierItem__r->IdItem] = 0;
					}

					$arrItemStock[$item->supplierItem__r->IdItem] += $item->Qty;
				// END CREATE ARRAY FOR UPDATING ITEM STOCK
			}

		// INSERT ITEM STOCK
			foreach($arrItemStock as $idItem => $stock){
				$itemStock = ItemStock::find()->where('IdItem = '.$idItem)->one();
				$itemStock->Stock += $stock;

				if(!$itemStock->save()){
					throw new \Exception('Update Item Stock gagal!');
				}
			}
		// END INSERT ITEM STOCK

			$transaction->commit();
			die('{"success":true, "PO":"'.$model->PoNumber.'"}');
		}catch (\Exception $e) {
			$transaction->rollBack();
            die('{"success":false, "message":'.$e->getMessage().'}');
        }
	}

	public function actionPrint($id){
		$model = PurchaseOrder::findOne($id);

        $logo = '<table class="table" style="width: 100%;">
                        <tr>
                            <td><img src="'.Yii::getAlias('@web')."/web/images/logos/document-logo.jpg".'" class="img-responsive" style="height:120px"></td>
                        </tr>
                    </table>';

		$content = $this->renderPartial('_print', [
            'model' => $model,
        ]);

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

		$pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'marginTop' => 50,
            'marginBottom' => 50,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content, 
            'filename' => 'PO'.$model->PoNumber.'.pdf',
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
                border:0;
                padding:0;
                margin-left:-0.00001;
            }
            .offset-8 {margin-left: 66.666667%;}
            .offset-2 {margin-left: 16.666667%;}
            .offset-1 {margin-left: 8.333333%;}
            .myfixed {position: fixed; right: 0mm; bottom: 0mm;}
            .table-content {border: 1px solid black}
            .table-content p{margin : 10px}
            .table-item{border: 1.5px solid black}
            .table-item tr{border:1px solid black}
            .table-item th{border:1px solid black}
            .table-item td{border:1px solid black}
            .table-item thead tr th{font-size : 12px}
            .table-item tbody tr td{font-size : 11px}
            .terms p {margin : 0px;font-size : 12px;}
            .table-sent-to{font-size : 11px}
            .table-type{font-size : 13px}
            .table-total{font-size : 11px}
            ',
            'options' => [
                'title' => 'PO'.$model->PoNumber,
                'defaultfooterline' => 0,
            ],
            'methods' => [
                'SetTitle' => 'PO'.$model->PoNumber,
                'SetHeader' => [
                    $logo
                ],
                'SetFooter' => ['
                    <table style="width:100%;font-family: `Times New Roman`, Times, serif;" >
                        <tr>
                            <td style="width: 20%;text-align:right;vertical-align:bottom">{PAGENO} / {nbpg}</td>
                        </tr>
                    </table>
                '],
                // 'SetFooter' => ['
                //     <table style="width:100%;font-family: `Times New Roman`, Times, serif;" >
                //         <tr>
                //             <td style="width: 20%">
                //                 <img style="width:15%" src="'.Yii::getAlias('@web').'/images/global-2.png"> 
                //             </td>
                //             <td style="width: 60%;font-size:8pt">
                //                 <b><i>Certificate of Compliance:</i></b>
                //                 <ul>
                //                     <li>ISO 9001 : 2015</li>
                //                     <li>ISO 14001 : 2015</li>
                //                     <li>OHSAS 18001 : 2007</li>
                //                 </ul>
                //             </td>
                //             <td style="width: 20%;text-align:right;vertical-align:bottom">
                //                 Page {PAGENO} / {nbpg}
                //             </td>
                //         </tr>
                //     </table>
                // '],
                // 'SetAuthor' => '@author Songo Enterprise',
                // 'SetCreator' => '@creator Songo Enterprise',
            ]
        ]);
        
        return $pdf->render(); 
	}
}

?>