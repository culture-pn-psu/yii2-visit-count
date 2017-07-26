<?php

namespace culturePnPsu\visitCount\models;

use Yii;
use culturePnPsu\visitBooking\models\Visitor;

/**
 * This is the model class for table "visit_count_visitor".
 *
 * @property int $count_visit_id
 * @property int $visitor_id
 * @property string $from
 * @property string $amount
 * @property string $note
 */
class VisitCountVisitor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visit_count_visitor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['visit_count_id', 'visitor_id', 'amount'], 'required'],
            [['visit_count_id', 'visitor_id'], 'integer'],
            [['amount'], 'number'],
            [['note'], 'string'],
            [['from'], 'string', 'max' => 255],
        ];
    }
    
    // public function scenarios(){
    //     $scenarios = self::scenarios();
    //     $scenarios['create'] = ['visit_count_id', 'visitor_id', 'amount'];
    //     return $scenarios;
    // }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'visit_count_id' => Yii::t('culture/visit-count', 'Count Visit ID'),
            'visitor_id' => Yii::t('culture/visit-count', 'Visitor ID'),
            'from' => Yii::t('culture/visit-count', 'From'),
            'amount' => Yii::t('culture/visit-count', 'Amount'),
            'note' => Yii::t('culture/visit-count', 'Note'),
        ];
    }
    
    public function getVisitor(){
        return $this->hasOne(Visitor::className(),['id'=>'visitor_id']);
    }
}
