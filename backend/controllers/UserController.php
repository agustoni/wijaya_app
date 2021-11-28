<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\SignupForm;

class UserController extends Controller{

	public function actionIndex(){
		
		return $this->render("index");
	}

	public function actionView(){

		return $this->render("view");
	}

	public function actionEdit(){

		return $this->render("edit");
	}

	public function actionCreate(){
		$model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            
            Yii::$app->session->setFlash('success', 'User berhasil dibuat');
            return $this->redirect(['/admin/user/index']);
            // return $this->goHome();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
	}
}

?>