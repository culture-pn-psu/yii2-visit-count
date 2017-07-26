<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use culturePnPsu\visitCount\models\VisitCountVisitor;
use miloschuman\highcharts\Highcharts;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitCount\models\VisitCount */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('culture/visit-count', 'Visit Counts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-count-view">

    <h1><?= Html::encode($model->learningCenter->title) ?></h1>
    <p>ช่วงวันที่
    <?php
    if($model->start_date==$model->end_date){
        echo  Yii::$app->formatter->asDate($model->start_date);
    }else{
         echo  Yii::$app->formatter->asDate($model->start_date).' - ';
         echo  Yii::$app->formatter->asDate($model->end_date);
    }?>
    </p> 
   
 <?php /*
    = DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'learning_center_id',
                'value'=>$model->learningCenter->title,
                ],
            'start_date:date',
            'end_date:date',
            'total',
            'note:ntext',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) */?>

<?php
// print_r(ArrayHelper::getColumn($arr, 'title'));
foreach($modelVisitors as $modelVisitor){
    
    $data[] = ['name' => $modelVisitor->visitor->title, 'y' => intval($modelVisitor->amount)];

}
echo Highcharts::widget([
    'options' => [
        'chart' => [
            'type' => 'column',
        ],
        'title' => ['text' => 'จำนวนผู้เข้าชม '.$model->learningCenter->title],
        'credits' => [
            'enabled' => false
        ],
        'xAxis' => [
            'categories' => ArrayHelper::getColumn($modelVisitors, 'visitor.title'),
            'crosshair' => true
        ],
        'yAxis' => [
            'min' => 0,
            'title' => [
                'text' => 'คน'
            ]
        ],
        'tooltip' => [
            'headerFormat' => '<span style="font-size:10px">{point.key}</span><table>',
            'pointFormat' => '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            'footerFormat' => '</table>',
            'shared' => true,
            'useHTML' => true
        ],
        'plotOptions' => [
            'column' => [
                'pointPadding' => 0.2,
                'borderWidth' => 0
            ]
        ],
        'series' => [
           [
                'name' => 'จำนวน',
                'colorByPoint' => true,
                'data' => $data
            ]
        ]
    ]
]);    
?>    
    
     <table class="table">
                <thead>
                    <?php
                   $newVisitor = new VisitCountVisitor();
                    ?>
                    <tr>
                        <th><?=Html::label('#')?></th>
                        <th><?=Html::activeLabel($newVisitor,'visit_id')?></th>
                        <th><?=Html::activeLabel($newVisitor,'amount')?></th>
                        <th><?=Html::activeLabel($newVisitor,'from')?></th>
                        <th><?=Html::activeLabel($newVisitor,'note')?></th>
                    </tr>
                </thead>
                <?php
                $index = 0;
                foreach($modelVisitors as $modelVisitor):?>
                <tr>
                    <td><?=(++$index)?></td>
                    <td><?=$modelVisitor->visitor->title?></td>
                    <td class="text-right"><?=$modelVisitor->amount.' '.Yii::t('culture','human');?></td>
                    <td> <?=$modelVisitor->from?> </td>
                    <td> <?=$modelVisitor->note?> </td>
                </tr>
                <?php endforeach;?>
                <tfooter>
                    <tr>
                        <td colspan="2" class="text-right">รวม</td>
                        <td class="text-right">
                            <?= $model->total?>
                        </td>
                        <td colspan="2">&nbsp;</td>
                        
                    </tr>
                </tfooter>
            </table>




    <p>
        <?= Html::a(Yii::t('culture/visit-count', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('culture/visit-count', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('culture/visit-count', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
