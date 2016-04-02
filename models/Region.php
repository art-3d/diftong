<?php

namespace app\models;

use Yii;
use app\models\Institution;
use yii\db\Query;

/**
 * This is the model class for table "l1v7_region".
 *
 * @property integer $id
 * @property string $title_ua
 * @property string $title_ru
 */
class Region extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'l1v7_region';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['title_ua', 'title_ru'], 'required'],
				[['title_ua', 'title_ru'], 'string', 'max' => 255]
		];
	}

	public function getCount_city()
	{
		return Institution::find()->where(['region_id' => $this->id])->count();
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
		];
	}
	
	public static function getAll()
	{
		$regions = (new Query())
				->select(['l1v7_region.*', 'count' => 'count(l1v7_city.id)'])
				->from('l1v7_region')
				->join('JOIN', 'l1v7_city', 'l1v7_region.id=l1v7_city.region_id')
				->groupBy('l1v7_region.id')
				->orderBy('count DESC')
				->all();
		
		return $regions;
	}
}
