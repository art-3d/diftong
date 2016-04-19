<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tech_subject}}".
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $title_ua
 * @property integer $is_checked
 * @property integer $tech_id
 * @property integer $direction_id
 * @property integer $created
 */
class TechSubject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tech_subject}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_checked', 'tech_id', 'direction_id', 'created'], 'integer'],
            [['tech_id', 'direction_id', 'created'], 'required'],
            [['title_ru', 'title_ua'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ru' => 'Title Ru',
            'title_ua' => 'Title Ua',
            'is_checked' => 'Is Checked',
            'tech_id' => 'Tech ID',
            'direction_id' => 'Direction ID',
            'created' => 'Created',
        ];
    }

    	public static function findByDirection($direction_id, $id)
	{
		$subjects = self::find()
			->where(['tech_id' => $id, 'direction_id' => $direction_id])
			->all();

		return $subjects;
	}
}
