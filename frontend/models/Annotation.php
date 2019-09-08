<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "annotation".
 *
 * @property int $id
 * @property string $documentTitle
 * @property string $annotation
 * @property string $creator
 * @property string $creatorEmail
 * @property string $creatorDesignation
 * @property string $created_at
 * @property string $updated_at
 */
class Annotation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'annotation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['documentTitle', 'annotation', 'creator', 'creatorEmail', 'creatorDesignation', 'created_at'], 'required'],
            [['documentTitle', 'annotation', 'creator', 'creatorEmail', 'creatorDesignation'], 'string'],
            [['created_at', 'updated_at','status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'documentTitle' => 'Document Title',
            'annotation' => 'Annotation',
            'creator' => 'Creator',
            'creatorEmail' => 'Creator Email',
            'creatorDesignation' => 'Creator Designation',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status'=>'Annotation Status'
        ];
    }
}
