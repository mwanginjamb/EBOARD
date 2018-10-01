<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "userType".
 *
 * @property int $id
 * @property string $user_type
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User[] $users
 */
class UserType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userType';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_type'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_type' => 'User Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['user_type_id' => 'id']);
    }
}
