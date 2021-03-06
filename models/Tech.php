<?php

namespace app\models;

use Yii;
use app\models\TechDirection;
use app\models\City;
use yii\db\Query;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%tech}}".
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $title_ua
 * @property string $title_en
 * @property integer $city_id
 */
class Tech extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%tech}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['title_ru', 'title_ua', 'city_id'], 'required'],
				[['city_id'], 'integer'],
				[['title_ru', 'title_ua'], 'string', 'max' => 512],
				[['title_en'], 'string', 'max' => 127]
		];
	}

	public function getCity()
	{
		return $this->hasOne(City::className(), ['id' => 'city_id']);
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
				'title_en' => 'Title En',
				'city_id' => 'City ID',
		];
	}

	public static function getAll( $lang = 'ru' )
	{
		if ( NULL == $lang || $lang == 'ru' ) {
					
			$techs = ( new Query() )
					->select(['id' => 'l1v7_tech.id', 'title' => 'l1v7_tech.title_ru', 'city' => 'l1v7_city.title_ru'])
					->from('l1v7_tech')
					->join('JOIN', 'l1v7_city', 'l1v7_tech.city_id=l1v7_city.id')
					->all();
		} else {

			$techs = ( new Query() )
					->select(['id' => 'l1v7_tech.id', 'title' => 'l1v7_tech.title_ua', 'city' => 'l1v7_city.title_ua'])
					->from('l1v7_tech')
					->join('JOIN', 'l1v7_city', 'l1v7_tech.city_id=l1v7_city.id')
					->all();
		}

		return $techs;
	}

	public static function findByRegion ( $region, $lang = 'ru' )
	{
		if(NULL == $lang || $lang == 'ru'){
				
			$techs = ( new Query() )
					->select(['l1v7_tech.*', 'city' => 'l1v7_city.title_ru'])
					->from('l1v7_tech')
					->join('JOIN', 'l1v7_city', 'l1v7_tech.city_id=l1v7_city.id')
					->where("l1v7_city.region_id=(SELECT id FROM l1v7_region where title_en='$region')")
					->all();

		} else {
					
			$techs = ( new Query() )
					->select(['l1v7_tech.*', 'city' => 'l1v7_city.title_ua'])
					->from('l1v7_tech')
					->join('JOIN', 'l1v7_city', 'l1v7_tech.city_id=l1v7_city.id')
					->where("l1v7_city.region_id=(SELECT id FROM l1v7_region where title_en='$region')")
					->all();
		}

		return $techs;
	}

	public static function findById($id)
	{
		$tech = ( new Query() )
			->select(['l1v7_tech.*', 'city' => 'l1v7_city.title_ru'])
			->from('l1v7_tech')
			->join('JOIN', 'l1v7_city', 'l1v7_tech.city_id=l1v7_city.id')
			->where(['l1v7_tech.id' => $id])
			->one();

		return $tech;
	}
	
	public static function findByDirId($id, $pagination = 15)
	{
	  $query = new Query();
	  $query
			  ->select(['l1v7_tech.*', 'city' => 'l1v7_city.title_ru'])
			  ->from('l1v7_tech')
			  ->join('JOIN', 'l1v7_institution_direction', 'l1v7_tech.id=l1v7_institution_direction.institution_id')
			  ->join('JOIN', 'l1v7_city', 'l1v7_city.id=l1v7_tech.city_id')
			  ->where(['l1v7_institution_direction.direction_id' => $id]);
	  $pagination = new Pagination([
			  'defaultPageSize' => 15,
			  'totalCount' => $query->count(),
	  ]);
	  $techs = $query
			  ->offset($pagination->offset)
			  ->limit($pagination->limit)
			  ->all();
		return ['techs' => $techs, 'pagination' => $pagination];	  	  
	}
}
