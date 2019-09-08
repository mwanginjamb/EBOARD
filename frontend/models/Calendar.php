<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "calendar".
 *
 * @property int $id
 * @property string $event
 * @property string $scheduled_date
 * @property string $start_time
 * @property string $end_time
 * @property string $venue
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $creator
 * @property string $creatorDesignation
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calendar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event', 'scheduled_date', 'venue', 'created_at'], 'required'],
            [['event', 'venue', 'creator', 'creatorDesignation'], 'string'],
            [['scheduled_date', 'start_time', 'end_time', 'created_at', 'updated_at'], 'safe'],
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event' => 'Event',
            'scheduled_date' => 'Scheduled Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'venue' => 'Venue',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'creator' => 'Creator',
            'creatorDesignation' => 'Creator Designation',
        ];
    }
    public function getVenue(){
        return $this->hasOne(Venue::className(),['id'=>'venue']);
    }
}
