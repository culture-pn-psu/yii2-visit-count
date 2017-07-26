<?php

namespace culturePnPsu\visitCount\models;

use Yii;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use mongosoft\file\UploadBehavior;
use culturePnPsu\learningCenter\models\LearningCenter;
/**
 * This is the model class for table "visit_count".
 *
 * @property int $id
 * @property int $learning_center_id
 * @property string $start_date
 * @property string $end_date
 * @property string $total
 * @property string $file
 * @property string $note
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class VisitCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visit_count';
    }
    
    /**
     * @inheritdoc
     */
    function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'file',
                //'attributeName' => 'file_name',
                'scenarios' => ['insert', 'update'],
                'path' => '@uploads/visit_count/{id}',
                'url' => '/uploads/visit_count/{id}',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['learning_center_id', 'start_date', 'end_date'], 'required'],
            [['learning_center_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['total'], 'number'],
            [['note'], 'string'],
            [['file'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('culture/visit-count', 'ID'),
            'learning_center_id' => Yii::t('culture/visit-count', 'Learning Center ID'),
            'start_date' => Yii::t('culture/visit-count', 'Start Date'),
            'end_date' => Yii::t('culture/visit-count', 'End Date'),
            'total' => Yii::t('culture/visit-count', 'Total'),
            'file' => Yii::t('culture/visit-count', 'File'),
            'note' => Yii::t('culture/visit-count', 'Note'),
            'created_at' => Yii::t('culture/visit-count', 'Created At'),
            'created_by' => Yii::t('culture/visit-count', 'Created By'),
            'updated_at' => Yii::t('culture/visit-count', 'Updated At'),
            'updated_by' => Yii::t('culture/visit-count', 'Updated By'),
        ];
    }
    
    public function getLearningCenter(){
        return $this->hasOne(LearningCenter::className(),['id'=>'learning_center_id']);
    }
    
    public function getVisitCountVisitor(){
        return $this->hasMany(VisitCountVisitor::className(),['visit_count_id'=>'id']);
    }
    
}
