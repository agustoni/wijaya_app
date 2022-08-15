<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\db\Query;

use backend\models\Project;
use backend\models\Item;
use backend\models\PurchaseOrderSearch;
use backend\models\PurchaseOrder;
use backend\models\PurchaseOrderItem;

class PurchaseOrderController extends Controller{
	public function actionIndex(){
		$searchModel = new PurchaseOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
}

?>