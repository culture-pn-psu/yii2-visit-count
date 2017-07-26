<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitCount\models\VisitCount */

$this->title = Yii::t('culture/visit-count', 'Create Visit Count');
$this->params['breadcrumbs'][] = ['label' => Yii::t('culture/visit-count', 'Visit Counts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-count-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelVisitor'=>$modelVisitor,
    ]) ?>

</div>
