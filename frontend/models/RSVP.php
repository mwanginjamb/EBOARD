<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "RSVP".
 *
 * @property int $RSVPID
 * @property int $CalenderID
 * @property int $RSVPStatusID
 * @property string $CreatedAt
 * @property string $UpdatedAt
 */
class RSVP extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'RSVP';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CalenderID', 'RSVPStatusID'], 'integer'],
            [['CreatedAt', 'UpdatedAt'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'RSVPID' => 'Rsvpid',
            'CalenderID' => 'Calender ID',
            'RSVPStatusID' => 'Rsvpstatus ID',
            'CreatedAt' => 'Created At',
            'UpdatedAt' => 'Updated At',
        ];
    }
}
