<?php

namespace backend\controllers;

use Yii;
use backend\models\ItemUnit;
use backend\models\ItemUnitSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ItemUnitController extends Controller{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ItemUnitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new ItemUnit();

        if ($model->load(Yii::$app->request->post())) {
            $uom = $_POST['ItemUnit']['UoM'];

            $check = ItemUnit::find()->where('UoM like "%'.$uom.'%"')->count();
            if($check == 0){
                $model->UoM = $uom;

                if(!$model->save()){
                    Yii::$app->session->setFlash('error', "UoM gagal disimpan!");
                }else{
                    Yii::$app->session->setFlash('success', "UoM berhasil disimpan");
                }
            }else{
                Yii::$app->session->setFlash('error', "UoM Sudah pernah dibuat");
            }

            return $this->redirect('create');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $uom = $_POST['ItemUnit']['UoM'];

            $check = ItemUnit::find()->where('UoM like "%'.$uom.'%"')->count();
            if($check == 0){
                $model->UoM = $uom;

                if(!$model->save()){
                    Yii::$app->session->setFlash('error', "UoM gagal disimpan!");
                }else{
                    Yii::$app->session->setFlash('success', "UoM berhasil disimpan");
                }
            }else{
                Yii::$app->session->setFlash('error', "UoM Sudah pernah dibuat");
            }

            return $this->redirect(['update', 'id'=>$id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = ItemUnit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
