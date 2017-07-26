<?php

namespace culturePnPsu\visitCount\controllers;

use Yii;
use culturePnPsu\visitCount\models\VisitCount;
use culturePnPsu\visitCount\models\VisitCountVisitor;
use culturePnPsu\visitCount\models\VisitCountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for VisitCount model.
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all VisitCount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VisitCountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VisitCount model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelVisitors = $model->visitCountVisitor;
        return $this->render('view', [
            'model' => $model,
            'modelVisitors' => $modelVisitors
        ]);
    }

    /**
     * Creates a new VisitCount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VisitCount();
        $modelVisitor = new VisitCountVisitor();

        if ($model->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post();
            print_r($post);
            //exit();
            
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $flag = false;
                if ($flag = $model->save(false)) {
                    $sum = 0;
                    foreach($post['VisitCountVisitor'] as $visitor_id => $item){
                        if($item['amount']!=0){
                            $modelVisitor = new VisitCountVisitor();
                            $modelVisitor->visit_count_id = $model->id; 
                            $modelVisitor->visitor_id = $visitor_id; 
                            $modelVisitor->amount = $item['amount']; 
                            $sum += $item['amount'];
                            $modelVisitor->from = $item['from']; 
                            $modelVisitor->note = $item['note']; 
                            if (($flag = $modelVisitor->save(false)) === false) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    $model->total = $sum;
                }
                
                
                 if ($flag) {
                    $transaction->commit();
                    if ($model->save()) {
                         return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        print_r($model->getErrors());
                    }
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        
        
        
        
        
        return $this->render('create', [
            'model' => $model,
            'modelVisitor'=>$modelVisitor,
        ]);
        
    }

    /**
     * Updates an existing VisitCount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelVisitor = $model->visitCountVisitor?$model->visitCountVisitor:new VisitCountVisitor();

        if ($model->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post();
            print_r($post);
            //exit();
            
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $flag = false;
                if ($flag = $model->save(false)) {
                    $sum = 0;
                    VisitCountVisitor::deleteAll(['visit_count_id'=>$model->id]);
                    foreach($post['VisitCountVisitor'] as $visitor_id => $item){
                        if($item['amount']!=0){
                            $modelVisitor = new VisitCountVisitor();
                            $modelVisitor->visit_count_id = $model->id; 
                            $modelVisitor->visitor_id = $visitor_id; 
                            $modelVisitor->amount = $item['amount']; 
                            $sum += $item['amount'];
                            $modelVisitor->from = $item['from']; 
                            $modelVisitor->note = $item['note']; 
                            if (($flag = $modelVisitor->save(false)) === false) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    $model->total = $sum;
                }
                
                
                 if ($flag) {
                    $transaction->commit();
                    if ($model->save()) {
                         return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        print_r($model->getErrors());
                    }
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        
        
        
        $modelVisitor = ArrayHelper::index($modelVisitor,'visitor_id');
        
        return $this->render('update', [
            'model' => $model,
            'modelVisitor'=>$modelVisitor,
        ]);
        
    }

    /**
     * Deletes an existing VisitCount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VisitCount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VisitCount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VisitCount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
