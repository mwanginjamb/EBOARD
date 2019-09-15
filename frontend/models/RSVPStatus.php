<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "RSVPStatus".
 *
 * @property int $RSVPStatusID
 * @property string $RSVPStatus
 * @property string $CreatedAt
 * @property string $UpdatedAt
 */
class RSVPStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'RSVPStatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['RSVPStatusID'], 'required'],
            [['RSVPStatusID'], 'integer'],
            [['RSVPStatus'], 'string'],
            [['CreatedAt', 'UpdatedAt'], 'safe'],
            [['RSVPStatusID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'RSVPStatusID' => 'Rsvpstatus ID',
            'RSVPStatus' => 'Rsvpstatus',
            'CreatedAt' => 'Created At',
            'UpdatedAt' => 'Updated At',
        ];
    }
}
