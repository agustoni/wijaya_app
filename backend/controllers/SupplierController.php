<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use backend\models\Supplier;
use backend\models\SupplierContact;

class SupplierController extends Controller{
	
	public function actionIndex(){
		$model = Supplier::find()->orderBy(['Id'=>SORT_DESC])->all();

		return $this->render("index", [
			'model' => $model
		]);
	}

	public function actionCreate(){
		$model = new Supplier;

		return $this->render('create', [
			'model' => $model
		]);
	}

	public function actionView($id){
		$model = Supplier::findOne($id);
		$supplierContact = [];

		foreach($model->supplierContact__r as $key => $cnt){
			// array_push($supplierContact, $cnt);
			$supplierContact[$key]['IdSupplierContact'] = $cnt->Id;
			$supplierContact[$key]['Name'] = $cnt->Name;
			$supplierContact[$key]['Phone'] = $cnt->Phone;
		}


		return $this->render('view', [
			'model' => $model,
			'supplierContact' => Json::encode($supplierContact)
		]);
	}

	public function actionCheckSupplierName(){
		$model = Supplier::find()->where('Name = "'.$_POST['supplierName'].'"')->one();
		$data = [];

		if($model){
			$data['Supplier']['IdSupplier'] = $model->Id;
			$data['Supplier']['Name'] = $model->Name;
			$data['Supplier']['Address'] = $model->Address;
			$data['Supplier']['Description'] = $model->Description;

			foreach($model->supplierContact__r as $key => $cnt){
				$data['SupplierContact'][$key]['IdSupplierContact'] = $cnt->Id;
				$data['SupplierContact'][$key]['IdSupplier'] = $cnt->IdSupplier;
				$data['SupplierContact'][$key]['Name'] = $cnt->Name;
				$data['SupplierContact'][$key]['Phone'] = $cnt->Phone;
			}
		}
		echo Json::encode($data);
		die;
		// die('{"success":true}');
	}

	public function actionSaveSupplier($id=null){
		$transaction = \Yii::$app->db->beginTransaction();
		$SplCntUpdate = ""; 
		$SplCntInsert = [];
		
		try{
			if($id){
				$model = Supplier::findOne($id);
			}else{
				$checkData = Supplier::find()->where("Name = '".$_POST['Supplier']['Name']."'")->one();
				if(!empty($checkData)){
					// throw new \Exception("Input gagal: Supplier yang dimasukan sudah terdaftar!"); 
					$model = Supplier::findOne($checkData->Id);
				}else{
					$model = new Supplier;
				}
			}

			$model->Name = $_POST['Supplier']['Name'];
			$model->Address = ($_POST['Supplier']['Address']? $_POST['Supplier']['Address'] : null);
			$model->Description = ($_POST['Supplier']['Description']? $_POST['Supplier']['Description'] : null);

			if($model->save()){
				if(isset($_POST['SupplierContact'])){
					foreach($_POST['SupplierContact'] as $cnt){
						if(!empty($cnt['IdSupplierContact'])){
							$SplCntUpdate .= "UPDATE supplier_contact SET IdSupplier = ".$model->Id.", Name = '".$cnt['Name']."', Phone = '".$cnt['Phone']."' WHERE Id = ".$cnt['IdSupplierContact'].";";
						}else{
							array_push($SplCntInsert, [
					            $model->Id, $cnt['Name'], $cnt['Phone']
					        ]);
						}
					}

					// UPDATE CONTACT
					if($SplCntUpdate != ""){
						$updateExec = \Yii::$app->db->createCommand($SplCntUpdate)->execute();
					}

					// INSERT CONTACT
					if(!empty($SplCntInsert)){
						$insertExec = Yii::$app->db->createCommand()->batchInsert('supplier_contact', 
				            ['IdSupplier', 'Name', 'Phone'], 
				            $SplCntInsert
				        )->execute();

				        if($insertExec == 0){
				        	throw new \Exception("Terjadi Kesalahan: save contact gagal!");
				        }
					}
				}

				$transaction->commit();
				
				die('{"success":true}');
			}else{
				throw new \Exception("Input gagal: Save supplier gagal"); 
			}
		}catch (\Exception $e) {
            $transaction->rollBack();

            die('{"success":false, "messages":'.json_encode($e->getMessage()).'}');
        }
	}

	public function actionDeleteSupplierContact(){
		$id = $_POST['IdSupplierContact'];
		$model = SupplierContact::findOne($id);

		if(!empty($model)){
			$model->delete();

			die('{"success":true}');
		}else{
			die('{"success":false, "messages":"Terjadi kesalahan: delete supplier contact failed!"}');
		}
	}
}

?>