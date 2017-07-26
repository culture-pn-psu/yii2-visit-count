<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitCount\models\VisitCount */

$this->title = Yii::t('culture/visit-count', 'Update {modelClass}: ', [
    'modelClass' => 'Visit Count',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('culture/visit-count', 'Visit Counts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('culture/visit-count', 'Update');
?>
<div class="visit-count-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelVisitor'=>$modelVisitor,
    ]) ?>

</div>
