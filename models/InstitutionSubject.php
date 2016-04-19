<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%institution_subject}}".
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $title_ua
 * @property integer $is_checked
 * @property integer $institution_id
 * @property integer $direction_id
 * @property integer $created
 */
class InstitutionSubject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%institution_subject}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_checked', 'institution_id', 'direction_id', 'created'], 'integer'],
            [['institution_id', 'direction_id', 'created'], 'required'],
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
            'institution_id' => 'Institution ID',
            'direction_id' => 'Direction ID',
            'created' => 'Created',
        ];
    }

    	public static function findByDirection($direction_id, $id)
	{
		if ( (int)$id < 1 ) {
			$title_en = $id;
			$id = ( new Query() )
				->select(['id'])
				->from('l1v7_institution')
				->where(['title_en' => $title_en])
				->one();
			$id = array_shift($id);
		}

		$subjects = self::find()
			->where(['institution_id' => $id, 'direction_id' => $direction_id])
			->all();

		return $subjects;
	}
}
