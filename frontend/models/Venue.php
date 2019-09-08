<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "venue".
 *
 * @property int $id
 * @property string $venue
 */
class Venue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'venue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['venue'], 'required'],
            [['venue'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'venue' => 'Venue',
        ];
    }
}
