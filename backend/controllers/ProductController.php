<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;

use backend\models\Item;
use backend\models\ItemPart;
use backend\models\ItemUnit;
use backend\models\ProductSearch;
use backend\models\Product;
use backend\models\ProductItem;

use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

class ProductController extends Controller{
	
	public function actionIndex(){
		$searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

	public function actionCreate(){

		return $this->render('create');
	}

	public function actionView($id){
		$model = Product::findOne($id);
		$productItemList = [];

		foreach($model->itemProduct__r as $idx => $item){
			$productItemList[$idx]['IdProductItem'] = $item->Id;
			$productItemList[$idx]['Name'] = $item->item__r->Name;
			$productItemList[$idx]['IdItem'] = $item->IdItem;
			$productItemList[$idx]['Description'] = $item->Description;
			$productItemList[$idx]['Update'] = 1;
		}

		return $this->render('view', [
			'model' => $model,
			'productItemList' => Json::encode($productItemList)
		]);
	}

	public function actionDeleteProductItem(){
		$delete = ProductItem::findOne($_POST['id']);
		$delete->delete();

		die('{"success":true}');
	}

	public function actionGetAllItem($q=null){
		$model = Item::find()->where('Name LIKE "%'.$q.'%"')->all();
		$data = [];

		foreach($model as $mdl){
			$data[] = ['id' => $mdl->Id, 'text' => $mdl->Name." (".$mdl->itemUnit__r->UoM.")"]; 
		}

		echo Json::encode($data);
		die;
	}

	public function actionSaveProduct(){
		$data = $_POST['Product'];
		$dataInsert = [];
		$dataUpdate = "";

		$transaction = \Yii::$app->db->beginTransaction();
		try{
			//===================== INSERT/UPDATE PRODUCT ===================== 
				if($data['IdProduct']){
					$modelPrd = Product::findOne($data['IdProduct']);
				}else{
					$modelPrd = new Product; 
				}

				$modelPrd->Name = $data['Name'];

				if(!$modelPrd->save()){
					throw new \Exception("Terjadi Kesalahan: ".json_encode($modelPrd->getErrors()));
				}

				$idProduct = $modelPrd->Id;
			//===================== END INSERT/UPDATE PRODUCT ===================== 

			//===================== INSERT/UPDATE PRODUCT ITEMS ===================== 
				foreach($data['ItemList'] as $item){
					if($item['IdProductItem']){
						$dataUpdate .= "UPDATE `product_item` SET `IdItem`=".$item['IdItem']." , Description = '".$item['Description']."' WHERE Id = ".$item['IdProductItem'].";";
					}else{
						array_push($dataInsert, [$idProduct, $item['IdItem'], $item['Description']]);
					}
				}

				//INSERT
				if(!empty($dataInsert)){
					$insertExec = Yii::$app->db->createCommand()->batchInsert('product_item', 
							            ['IdProduct', 'IdItem', 'Description'], 
							            $dataInsert
							        )->execute();
					if($insertExec == 0){
						throw new \Exception("Terjadi Kesalahan: insert product item gagal!");
					}
				}

				//UPDATE
				// if($dataUpdate != ''){
				// 	$updateExec = \Yii::$app->db->createCommand($dataUpdate)->execute();

				// 	if($updateExec == 0){
				// 		throw new \Exception("Terjadi Kesalahan: update product item gagal!");
				// 	}
				// }
			//===================== END INSERT/UPDATE PRODUCT ITEMS ===================== 

			$transaction->commit();
			die('{"success":true}');
		}catch (\Exception $e) {
            $transaction->rollBack();

            die('{"success":false, "messages":'.json_encode($e->getMessage()).'}');
        }
	}
}

?>