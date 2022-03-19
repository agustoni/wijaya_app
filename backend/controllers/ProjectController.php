<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
// use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\db\Query;

use backend\models\Project;
use backend\models\ProjectType;
use backend\models\Item;
use backend\models\ItemUnit;
use backend\models\SupplierItem;
use backend\models\ProjectWorker;
use backend\models\Product;

class ProjectController extends Controller{
	public function actionIndex(){
		$model = Project::find()->all();

		return $this->render("index",[
			"model" => $model
		]);
	}

	public function actionCreate(){
		$projectType = ProjectType::find()->where("Status = 1")->all();
		$role = new ProjectWorker;

		return $this->render('create', [
			"projectType" => $projectType,
		]);
	}

	public function actionView($id){
		$projectType = ProjectType::find()->where("Status = 1")->all();
		$role = new ProjectWorker;

		$dataProject = $this->getDataProject();

		return $this->render('view', ['id'=>$id,"projectType" => $projectType, 'dataProject' => $dataProject]);
	}

	public function actionGetSalesItem($q){
		$model = new Item;
		$allSalesItem = $model->getSalesItem($q);

		$data = [];
        foreach ($data as $d) {
            $data[] = ['IdItem' => $d['IdItem'], 'IdSupplierItem' => $d['IdSupplierItem'], 'Name' => $d['ItemName'], 'UoM' => $d['UoM'], 'Cost' => $d['LastPrice'], 'StatusExp' => $d['StatusExp'], 'LastUpdated' => date('d-m-Y', strtotime($d['LastUpdated']))];
        }

        echo Json::encode($data);
        die;
	}

	public function actionGetWorker($q){
		$query = new Query;
        $query->select('usr.id as Id, usr.name as Name')
              ->from('auth_assignment ua')
              ->leftJoin('user usr', 'ua.user_id = usr.id')
              ->where('ua.item_name = "Worker" AND usr.id NOT IN(1) AND usr.name  LIKE "%'.$q.'%"')
              ->orderBy('usr.username ASC');

        $worker = $query->createCommand()->queryAll();

        echo Json::encode($worker);
        die;
	}

	public function actionGetAllProduct($q=null){
		$model = new Product;
		$allProduct = $model->getAllProduct($q);

		$data = [];
		$idx = 0;
    	foreach ($allProduct as $d) {
    		if(!array_search($d['IdPrd'], array_column($data, 'id'))){
    			$data[$idx] = ['id' => $d['IdPrd'], 'text' => $d['PrdName']]; 
    			$listItemCounter = 0;

    			$data[$idx]['listitem'][$listItemCounter] = [
    				'Id' => $d['IdPrdItem'],
    				'IdSupplierItem' => $d['IdSupplierItem'],
    				'IdItem' => $d['IdItem'],
    				'ItemName' => $d['ItemName'],
    				'UoM' => $d['UoM'],
    				'Qty' => $d['Qty'],
    				'Cost' => $d['LastPrice'],
    				'StatusExp' => $d['StatusExp'],
    				'LastUpdated' => date('d-m-Y', strtotime($d['LastUpdated']))
    			];

    			$idx++;
    			$listItemCounter++;
    		}else{
    			$idx = array_search($d['IdPrd'], array_column($data, 'id'));

    			$data[$idx]['listitem'][$listItemCounter] = [
    				'Id' => $d['IdPrdItem'],
    				'IdItem' => $d['IdItem'],
    				'ItemName' => $d['ItemName'],
    				'UoM' => $d['UoM'],
    				'Qty' => $d['Qty'],
    				'Cost' => $d['LastPrice'],
    				'StatusExp' => $d['StatusExp'],
    				'LastUpdated' => date('d-m-Y', strtotime($d['LastUpdated']))
    			];

    			$listItemCounter++;
    		}
        }

		echo Json::encode($data);
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

	// ********** DEV SECTION **********
		public function getDataProject(){
			$data = [
				"Client" => [
					"Company" => "'PT Lintas Batas",
					"Address" => "Jalan Semangka no 13 B, Kelurahan kebun buah, Kecamatan: Pasar buah, Semarang, 154621",
					"Contact" => [
						"0" => [
							"Id" => 1,
							"Name" => "Sugeng",
							"Title" => "CEO",
							"Role" => "",
							"Phone" => "08927237323",
							"Email" => "sugeng@mail.com"  	
						],
						"1" => [
							"Id" => 2,
							"Name" => "Tya",
							"Title" => "PIC/Building Chief Engineer",
							"Role" => "",
							"Phone" => "0839153123",
							"Email" => "tya@mail.com" 	
						],
					]
				],
				"Detail" => [
					"IdProjectType" => 2,
					"DetailDescription" => "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"
				],
				"DetailItem" => [
					"0" => [
						"id" => 2,
						"listitem" => [
							"0" => [
								"Id" => 5,
								"IdItem" => 4,
								// "IdSupplier" => 1,
								"Cost" => 1500000,
								"ItemName" => "CPU",
								"LastUpdated" => "26-01-2022",
								"Qty" => 1,
								"StatusExp" => 1,
								"UoM" => "Unit"
							]
						],
						"text" => "Lift 1",
						"total" => [
							"Cost" => "1500000",
							"Price" => "2500000",
							"Margin" => "1000000",
						]
					],
					"1" => [
						"id" => 3,
						"listitem" => [
							"0" => [
								"Id" => 7,
								"IdItem" => 4,
								// "IdSupplier" => 1,
								"Cost" => 1500000,
								"ItemName" => "CPU",
								"LastUpdated" => "26-01-2022",
								"Qty" => 1,
								"StatusExp" => 1,
								"UoM" => "Unit"
							],
							"1" => [
								"Id" => 8,
								"IdItem" => 5,
								// "IdSupplier" => 1,
								"Cost" => 450000,
								"ItemName" => "Stabilizer",
								"LastUpdated" => "26-10-2021",
								"Qty" => 1,
								"StatusExp" => 0,
								"UoM" => "Unit"
							],
							"2" => [
								"Id" => 9,
								"IdItem" => 6,
								// "IdSupplier" => 1,
								"Cost" => 14000,
								"ItemName" => "Paku Payung",
								"LastUpdated" => "26-10-2021",
								"Qty" => 1,
								"StatusExp" => 1,
								"UoM" => "Pack"
							],
							"3" => [
								"Id" => 10,
								"IdItem" => 7,
								// "IdSupplier" => 1,
								"Cost" => 150000,
								"ItemName" => "Paku Tembok",
								"LastUpdated" => "26-10-2021",
								"Qty" => 10,
								"StatusExp" => 0,
								"UoM" => "Pack"
							]
						],
						"text" => "Lift 2",
						"total" => [
							"Cost" => "3464000",
							"Price" => "6464000",
							"Margin" => "3000000",
						]
					]
				],
				"Worker" => [
					"0" => [
						"Id" => 2,
						"Name" => "Pekerja 1",
						"Role" => "Koordinator",
						"StartAt" => "15-01-2022",
						'StatusDate' => (strtotime(date("15-01-2022")) <= strtotime(date('d-m-Y'))? '0' : '1')
					],
					"1" => [
						"Id" => 3,
						"Name" => "Pekerja 2",
						"Role" => "Pekerja",
						"StartAt" => "03-03-2022",
						'StatusDate' => (strtotime(date("15-03-2022")) <= strtotime(date('d-m-Y'))? '0' : '1')
					]
				],
				"Payment" => [
					
				]
			];

			return Json::encode($data);
		} 

		public function actionTestModul(){
			return $this->render('test-modul');
		}
	// ********** END DEV SECTION **********
}

?>