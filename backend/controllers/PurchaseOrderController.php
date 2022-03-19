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


// use backend\models\Project;
// use backend\models\ProjectType;
// use backend\models\Item;
// use backend\models\ItemUnit;
// use backend\models\SupplierItem;
// use backend\models\ProjectWorker;
// use backend\models\Product;

class PurchaseOrderController extends Controller{
	public function actionIndex(){
		// $model = Project::find()->all();

		// return $this->render("index",[
		// 	"model" => $model
		// ]);

		return $this->render('index');
	}

	public function actionCreate($id=null){
		if($id != null){
			// $model = Project::findOne($id);
			$model = $this->dummyData();

			// echo "<pre>";
			// print_r($model);
			// die;
		}else{
			$model = new Project;
		}

		return $this->render("create", ["model" => $model]);
	}

	public function actionGetSalesItem($q){
		$model = new Item;
		$allSalesItem = $model->getSalesItem($q);

		$data = [];
        foreach ($allSalesItem as $d) {
            $data[] = ['IdItem' => $d['IdItem'], 'IdSupplierItem' => $d['IdSupplierItem'], 'Name' => $d['ItemName'], 'UoM' => $d['UoM'], 'Cost' => $d['LastPrice'], 'StatusExp' => $d['StatusExp'], 'LastUpdated' => date('d-m-Y', strtotime($d['LastUpdated']))];
        }

        echo Json::encode($data);
        die;
	}

	public function actionGetSupplierItem(){
		$model = new Item;
		$allSupplierItem = $model->getSupplierItem($_POST['IdItem']);

		$data = [];
		foreach($allSupplierItem as $spl){
			$data[] = ['IdSupplierItem' => $spl['IdSupplierItem'], 'IdSupplier' => $spl['IdSupplier'], 'SupplierName' => $spl['SupplierName'], 'Price' => $spl['LastPrice']];
		}

		echo Json::encode($data);
        die;
	}

	public function dummyData(){
		$data = [
			''
		];

		return $data;
	}
}

?>