<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "documents".
 *
 * @property int $id
 * @property int $parent_document_id
 * @property int $child_document_id
 * @property int $size
 * @property string $title
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $document_type
 * @property string $path
 * @property string $created_by
 * @property string $updated_by
 */
class Documents extends \yii\db\ActiveRecord
{
    public $files;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_document_id', 'child_document_id', 'size', 'status'], 'integer'],
            [['title', 'document_type', 'path', 'created_by', 'updated_by'], 'string'],
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
            'parent_document_id' => 'Parent Document ID',
            'child_document_id' => 'Child Document ID',
            'size' => 'Size',
            'title' => 'Title',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'document_type' => 'Document Type',
            'path' => 'Path',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
