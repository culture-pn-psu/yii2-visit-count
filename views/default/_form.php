<?php

use yii\helpers\Url;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

use kartik\widgets\DatePicker;

use kartik\widgets\FileInput;

use culturePnPsu\visitCount\models\VisitCountVisitor;
use culturePnPsu\visitBooking\models\Visitor;
use culturePnPsu\learningCenter\models\LearningCenter;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\visitCount\models\VisitCount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visit-count-form">

     <?php $form = ActiveForm::begin([
            'action' => $formAction?$formAction:'',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{endWrapper}\n{error}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-3',
                    'offset' => 'col-sm-offset-2',
                    'wrapper' => 'col-sm-7',
                    'error' => '',
                    'hint' => '',
                ],
            ],
        ]); ?>

    <?= $form->field($model, 'learning_center_id')->dropDownList(LearningCenter::getList(),['prompt'=>Yii::t('culture','Select')]) ?>

    
    
    
    <?php
$layout3 = <<< HTML
    <span class="input-group-addon" title="เลือกวันที่"><i class="glyphicon glyphicon-calendar"></i></span>
    {input1}
    <span class="input-group-addon">To Date</span>
    {input2}
    <span class="input-group-addon kv-date-remove">
        <i class="glyphicon glyphicon-remove"></i>
    </span>
HTML;
    $templateModel['horizontalCssClasses'] = [
        'label' => 'col-sm-3',
        'offset' => 'col-sm-offset-4',
        'wrapper' => 'col-sm-6',
        'error' => '',
        'hint' => '',
    ];
    
    echo $form->field($model, 'start_date')->widget(DatePicker::className(),[
        //'name2' => 'end_date',
        'attribute2' => 'end_date',
        'options' => ['placeholder' => 'Start date'],
        'options2' => ['placeholder' => 'End date'],
        'type' => DatePicker::TYPE_RANGE,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
            'todayBtn' => true,
        ],
        'layout' => $layout3,
    ]);
    
   
    ?>


    <div class="form-group ">
        <label class="control-label col-sm-3" ><?=Yii::t('culture/visit-count','Visit Count Visitor')?></label>
        <div class="col-sm-8">
            <table class="table">
                <thead>
                    <?php
                    //$visitor = new Visitor;
                    $templateModel['horizontalCssClasses'] = [
                        'label' => false,
                        'offset' => false,
                        'wrapper' => 'col-sm-12',
                        'error' => '',
                        'hint' => '',
                    ];
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
                foreach(Visitor::getList(Visitor::TYPE_PERSON) as $visitor_id => $visitor_title):?>
                <tr>
                    <td><?=(++$index)?></td>
                    <td><?=$visitor_title?></td>
                    <td>
                        <?= $form->field($newVisitor, "[{$visitor_id}]amount",$templateModel)
                        ->textInput([
                            'value'=>$modelVisitor[$visitor_id]->amount,
                            'maxlength' => true,
                            'class'=>'form-control visitcountvisitor-amount'
                        ])->label(false)->hint(false)->error(false) ?>
                    </td>
                    <td><?= $form->field($newVisitor, "[{$visitor_id}]from",$templateModel)->textInput([
                        'value'=>$modelVisitor[$visitor_id]->from,
                    ])->label(false)->hint(false)->error(false) ?></td>
                    <td><?= $form->field($newVisitor, "[{$visitor_id}]note",$templateModel)->textInput([
                        'value'=>$modelVisitor[$visitor_id]->note,
                    ])->label(false)->hint(false)->error(false) ?></td>
                </tr>
                <?php endforeach;?>
                <tfooter>
                    <tr>
                        <td colspan="2" class="text-right">รวม</td>
                        <td  class="text-right">
                            <?= $form->field($model, 'total',$templateModel)->textInput(['maxlength' => true,'readonly'=>true])->label(false)->hint(false)->error(false) ?>
                        </td>
                    </tr>
                </tfooter>
            </table>
        </div>
    </div>
    
    

    <?= $form->field($model, 'file')->widget(FileInput::classname(), [
            'options' => ['accept' => 'pdf/*'],
            'pluginOptions' => [
              'previewFileType' => 'pdf',
              //'showPreview' => false,
              'showCaption' => false,
              'elCaptionText' => '#customCaption',
              'uploadUrl' => Url::to(['/edoc/default/file-upload'])
            ]
        ]);?>
    
    
    
    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>


     
    <div class="form-group ">
        <div class="col-sm-offset-3 col-sm-6">
            <?= Html::submitButton(Yii::t('culture/visit-count', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php

$js[] = <<< JS

    $("input.visitcountvisitor-amount").each(function(index){
         $(this).on('keyup',function(){
             getTotal()
             //alert($(this).val());
         });
     });

    function getTotal(){
         var total = 0;
         $("input.visitcountvisitor-amount").each(function(index){
             total+=1*$(this).val();
         });
         $("input#visitcount-total").val(total);
    }
JS;

$this->registerJs(implode("\n",$js));
