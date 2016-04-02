<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "l1v7_city".
 *
 * @property integer $id
 * @property string $title_ua
 * @property string $title_ru
 * @property integer $region_id
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'l1v7_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_ua', 'title_ru', 'region_id'], 'required'],
            [['region_id'], 'integer'],
            [['title_ua', 'title_ru'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ua' => 'Title Ua',
            'title_ru' => 'Title Ru',
            'region_id' => 'Region ID',
        ];
    }
}
