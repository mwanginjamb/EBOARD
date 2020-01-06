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
  *@property string $ProfileID
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
            [['CalendarID', 'RSVPStatusID','ProfileID'], 'integer'],
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
            'CalendarID' => 'Calender ID',
            'RSVPStatusID' => 'Rsvpstatus ID',
            'CreatedAt' => 'Created At',
            'UpdatedAt' => 'Updated At',
        ];
    }

    public function getProfile(){
      return $this->hasOne(Profile::className(), ['id' => 'ProfileID']);
    }

     public function getRsvp(){
      return $this->hasOne(RSVPStatus::className(), ['id' => 'RSVPStatusID']);
    }

    public function getEvent(){
      return $this->hasOne(Calendar::className(),['id'=> 'CalendarID']);
    }
}
