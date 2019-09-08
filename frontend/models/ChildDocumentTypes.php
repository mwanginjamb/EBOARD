<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "childDocumentTypes".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property int $size
 * @property string $created_at
 * @property string $update_at
 * @property string $creator
 * @property int $status
 *
 * @property ParentDocumentType $parent
 * @property Documents[] $documents
 */
class ChildDocumentTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'childDocumentTypes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'title'], 'required'],
            [['parent_id', 'size', 'status'], 'integer'],
            [['title', 'creator'], 'string'],
            [['created_at', 'update_at'], 'safe'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ParentDocumentType::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent Folder',
            'title' => 'Sub Folder Name',
            'size' => 'Size',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
            'creator' => 'Creator',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ParentDocumentType::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(Documents::className(), ['child_document_id' => 'id']);
    }
}
