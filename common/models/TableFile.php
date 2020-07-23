<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property string $name
 * @property string $web_filename
 * @property integer $status
 * @property string $created_at
 * @property string $path
 * @property integer $user_id
 */
class TableFile extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%table_file}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['name', 'web_filename', 'created_at', 'path'], 'string'],
            ['user_id', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
        'id' => Yii::t('app', 'ID'),
        'name' => Yii::t('app', 'File name'),
        'user_id' => Yii::t('app', 'Uploader'),
        'created_at' => Yii::t('app', 'Upload date'),
        'status' => Yii::t('app', 'Status'),        
        ];
    }

    /**
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
            self::STATUS_DELETED => Yii::t('app', 'Deleted'),
        ];
    }
}
