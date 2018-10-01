<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "parentDocumentType".
 *
 * @property int $id
 * @property string $title
 * @property int $size
 * @property string $updated_at
 * @property string $created_at
 * @property string $creator
 * @property int $status
 * @property string $user_type_ids
 *
 * @property ChildDocumentTypes[] $childDocumentTypes
 */
class ParentDocumentType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parentDocumentType';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'creator', 'user_type_ids'], 'string'],
            [['size', 'status'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Folder Name',
            'size' => 'Size',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'creator' => 'Creator',
            'status' => 'Status',
            'user_type_ids' => 'User Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildDocumentTypes()
    {
        return $this->hasMany(ChildDocumentTypes::className(), ['parent_id' => 'id']);
    }
}
