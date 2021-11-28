<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\db\Query;

use backend\models\Project;
use backend\models\ProjectType;
use backend\models\Item;
use backend\models\ItemUnit;

use backend\models\SupplierItem;

class ProjectController extends Controller{
	public function actionIndex(){
		$model = Project::find()->all();

		return $this->render("index",[
			"model" => $model
		]);
	}

	public function actionCreate(){
		$projectType = ProjectType::find()->where("Status = 1")->all();

		return $this->render('create', [
			"projectType" => $projectType
		]);
	}

	public function actionGetSalesItem($q){
// ==================================================================================================================
		// $query = new Query;
  //       $query->select('item__r.Id IdItem, item__r.Name ItemName, itemUnit__r.UoM, 
		// idSupplier__r.Id IdSupplier, idSupplier__r.Name SupplierName,
		// supplier_item.Price LastPrice, supplier_item.LastUpdated LastUpdated,
		// supplierItemCost__r.Price PurchasePrice, supplierItemCost__r.Created_At PurchaseAt,
		// if((supplier_item.LastUpdated BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW()) OR (supplierItemCost__r.Created_At BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW()), "1", "0") StatusPrice')
  //             ->from('supplier_item')
  //             ->leftJoin('item item__r', 'supplier_item.IdItem = item__r.Id')
  //             ->leftJoin('item_unit itemUnit__r', 'item__r.IdUoM = itemUnit__r.Id')
  //             ->leftJoin('supplier_item_cost supplierItemCost__r', 'supplier_item.Id = supplierItemCost__r.IdSupplierItem')
  //             ->leftJoin('supplier idSupplier__r', 'supplier_item.IdSupplier = idSupplier__r.Id')
  //             ->where('item__r.Name LIKE "%'.$q.'%" 
  //             			/*AND (
		// 				    supplier_item.LastUpdated BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW()
		// 					OR supplierItemCost__r.Created_At BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW()
		// 				)*/
		// 				AND supplier_item.LastUpdated = (
		// 					SELECT MAX(supplier_item2.LastUpdated)
		// 				    FROM supplier_item supplier_item2
		// 				    WHERE supplier_item.IdItem = supplier_item2.IdItem
		// 				)')
  //             ->groupBy('item__r.Id')
  //             ->orderBy('item__r.Name ASC, supplier_item.LastUpdated DESC, supplierItemCost__r.Created_At DESC');
  //       $data = $query->createCommand()->queryAll();
// ==================================================================================================================
		$data = Yii::$app->db->createCommand('SELECT item__r.Id IdItem, item__r.Name ItemName, itemUnit__r.UoM, 
													supplier_item.Id IdSupplierItem, idSupplier__r.Id IdSupplier, idSupplier__r.Name SupplierName,
													supplier_item.Price LastPrice, supplier_item.LastUpdated LastUpdated,
													supplierItemCost__r.Price PurchasePrice, supplierItemCost__r.Created_At PurchaseAt,
													if(supplier_item.LastUpdated BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW() OR supplierItemCost__r.Created_At BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW(), 1, 0) StatusPrice
											FROM `supplier_item` 
											LEFT JOIN `item` `item__r` ON supplier_item.IdItem = item__r.Id 
											LEFT JOIN `item_unit` `itemUnit__r` ON item__r.IdUoM = itemUnit__r.Id 
											LEFT JOIN `supplier_item_cost` `supplierItemCost__r` ON supplier_item.Id = supplierItemCost__r.IdSupplierItem 
											LEFT JOIN `supplier` `idSupplier__r` ON supplier_item.IdSupplier = idSupplier__r.Id 
											WHERE item__r.Name LIKE "%'.$q.'%"
											/*AND (
												supplier_item.LastUpdated BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW()
												OR supplierItemCost__r.Created_At BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW()
											)*/
											AND supplier_item.LastUpdated = (
											SELECT MAX(supplier_item2.LastUpdated)
											FROM supplier_item supplier_item2
											WHERE supplier_item.IdItem = supplier_item2.IdItem
											) GROUP BY `item__r`.`Id` 
											ORDER BY `supplier_item`.`LastUpdated` DESC, `supplierItemCost__r`.`Created_At` DESC, `item__r`.`Name`')->queryAll();

    	$out = [];
    	foreach ($data as $d) {
            $out[] = ['IdItem' => $d['IdItem'], 'IdSupplierItem' => $d['IdSupplierItem'], 'Name' => $d['ItemName'], 'UoM' => $d['UoM'], 'Price' => $d['LastPrice'], 'StatusPrice' => $d['StatusPrice']];
        }

        // echo "<pre>";
        // print_r($out);
        // die;

        echo Json::encode($out);
        die;
	}

	public function actionDeleteProjectContact(){
		$idProjectContact = $_POST['idProjectContact'];

		// echo $idProjectContact;
		die('{"success":true}');
		// $transaction = \Yii::$app->db->beginTransaction();

		// $model = ItemPart::findOne($idItemPart);

		// if(!empty($model)){
		// 	$model->delete();

		// 	$transaction->commit();
		// 	die('{"success":true}');
		// }else{
		// 	$transaction->rollBack();

		// 	die('{"success":false, "messages":"Terjadi kesalahan: delete item part failed!"}');
		// }
	}
}

?>