<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;

use backend\models\ItemSearch;
use backend\models\Item;
use backend\models\ItemPart;
use backend\models\ItemUnit;

use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

class ItemController extends Controller{
	public function actionIndex(){
		$searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

	public function actionView($id){
		$model = Item::findOne($id);
		$itemType = new Item;
		$itemPart = null;

		if($model->Type == 2){
			$itemPart = Json::encode($this->getItemCombined('', $id));
		}

		return $this->render('view', [
			'model' => $model,
			"itemType" => $itemType,
			'itemPart' => $itemPart
		]);
	}

	public function actionCreateItem(){
		$model = new Item;

		return $this->render('create-item', [
			"model" => $model
		]);
	}

	public function actionCreateItemCombined(){
		$model = new Item;

		return $this->render('create-item-Combined', [
			"model" => $model
		]);
	}

	public function actionSaveItem($id=null){
		$transaction = \Yii::$app->db->beginTransaction();

		try{
			$idItem = $_POST['IdItem'];
			$name = $_POST['Name'];
			$uom = $_POST['IdUoM'];
			$type = $_POST['Type'];
			$description = $_POST['Description'];

			if($idItem){
				$model = Item::findOne($idItem);
			}else{
				$model = new Item;

				// check apakah item dengan IdUoM yang di-input sudah ada
				$checkData = Item::find()->where("Name = '".$name."' AND IdUoM = ".$uom." AND Type = ".$type)->one();
				if(!empty($checkData)){
					throw new \Exception("Input gagal: Item yang dimasukan sudah terdaftar!"); 
				}
			}

			if(!$uom){
				$uom = $this->saveUom($_POST['NewUoM']);
			}
		
			$model->Name = $name;
			$model->IdUoM = $uom;
			$model->Type = $type;
			$model->Description = $description;

			if($model->save()){
				$transaction->commit();
				
				die('{"success":true}');
			}else{
				throw new \Exception("Input gagal: Save item gagal"); 
			}
		}catch (\Exception $e) {
            $transaction->rollBack();

            die('{"success":false, "messages":'.json_encode($e->getMessage()).'}');
        }
	}

	public function actionSaveItemCombined(){
		$transaction = \Yii::$app->db->beginTransaction();

		try{
			$dataInsert = [];
			$dataUpdate = "";
			$idPartParent = $_POST['IdItemParent'];

			foreach($_POST['ItemPart'] as $ipt){
				$description = (empty($ipt['Description']))? null : $ipt['Description'];

				if(empty($ipt['IdItemPart'])){
					// 	QUERY NEW RECORD
					array_push($dataInsert, [
			            $idPartParent, $ipt['IdItem'], $ipt['Qty'], $description
			        ]);
				}else{
					// QUERY UPDATE RECORD
					$dataUpdate .= "UPDATE item_part SET IdItem = ".$ipt['IdItem'].", Qty = ".$ipt['Qty'].", Description = '".$description."' WHERE Id = ".$ipt['IdItemPart'].";";
				}
			}

			// UPDATE DATA PART
			if(!empty($dataUpdate)){
				$updateExec = \Yii::$app->db->createCommand($dataUpdate)->execute();
			}

			// INSERT NEW PART
			if(!empty($dataInsert)){
				$saveItemPart = Yii::$app->db->createCommand()->batchInsert('item_part', 
		            ['IdParentItem', 'IdItem', 'Qty', 'Description'], 
		            $dataInsert
		        )->execute();

		        if($saveItemPart == 0){
		        	throw new \Exception("Terjadi Kesalahan: save item part failed!");
		        }
			}

			$transaction->commit();
			die('{"success":true}');
		}catch (\Exception $e) {
			$transaction->rollBack();

            die('{"success":false, "messages":'.json_encode($e->getMessage()).'}');
		}
	}

	public function actionDeletePartCombined(){
		$idItemPart = $_POST['idItemPart'];
		$transaction = \Yii::$app->db->beginTransaction();

		$model = ItemPart::findOne($idItemPart);

		if(!empty($model)){
			$model->delete();

			$transaction->commit();
			die('{"success":true}');
		}else{
			$transaction->rollBack();

			die('{"success":false, "messages":"Terjadi kesalahan: delete item part failed!"}');
		}
	}

	public function actionGetUom($q){
        // $data = DataClients::find()->where('Name LIKE "%' . $q .'%" OR Phone LIKE "%' . $q .'%" ')->all();
        $data = ItemUnit::find()->where('UoM LIKE "%' . $q .'%"')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = [
            	'Id' => $d->Id, 
            	'UoM' => $d->UoM
            ];
        }
        echo Json::encode($out);
        die;
    }

    public function actionGetAllItem($q){
    	$data = Item::find()->where('Name LIKE "%' . $q .'%"')->all();
    	$out = [];
    	foreach ($data as $d) {
            $out[] = [
            	'Id' => $d->Id, 
            	'Name' => $d->Name, 
            	'UoM' => $d->itemUnit__r->UoM
            ];
        }
        echo Json::encode($out);
        die;
    }

    public function actionGetAllItemCombined($q = null, $preSelect = null){
    	$out = $this->getItemCombined($q, $preSelect);
        echo Json::encode($out);
        die;
    }

    public function getItemCombined($q, $preSelect){
    	$modelItem = new Item;
    	$itemType = $modelItem->itemType;

    	$out = [];

    	if($preSelect != null){
    		$data = Item::findOne($preSelect);
    		$itemPart = [];

    		foreach($data->itemPartParent__r as $part){
    			$itemPart[] = [
    				'IdItemPart' => $part->Id, 
    				'Id' => $part->IdItem, 
    				'Part' => $part->item__r->Name, 
    				'UoM' => $part->item__r->itemUnit__r->UoM, 
    				'Qty' => $part->Qty, 
    				'Description' => $part->Description
    			];
    		}

            $out[] = ['Id' => $data->Id, 'Name' => $data->Name." (".$data->itemUnit__r->UoM.")", 'ItemPart' => $itemPart];
    	}else{
    		$data = Item::find()->where('Name LIKE "%' . $q .'%" AND Type = 2')->all();

    		foreach ($data as $d) {
	    		$itemPart = [];

	    		foreach($d->itemPartParent__r as $part){
	    			$itemPart[] = [
	    				'IdItemPart' => $part->Id, 
	    				'Id' => $part->IdItem, 
	    				'Part' => $part->item__r->Name, 
	    				'UoM' => $part->item__r->itemUnit__r->UoM, 
	    				'Qty' => $part->Qty, 
	    				'Description' => $part->Description
	    			];
	    		}

	            $out[] = [
	            	'Id' => $d->Id, 
	            	'Name' => $d->Name." (".$d->itemUnit__r->UoM.")", 
	            	'ItemPart' => $itemPart
	            ];
	        }
    	}

        return $out;
    }

    public function saveUom($uom){
		$model = ItemUnit::find()->where('UoM = "'.$uom.'"')->one();

		if(!empty($model)){
			return $model->Id;
		}else{
			$newUoM = new ItemUnit;

			$newUoM->UoM = $uom;
			$newUoM->save();

			return $newUoM->Id;
		}
	}
}

?>