<?php

namespace app\models;

use Yii;
use app\models\City;
use yii\db\Query;
use yii\data\Pagination;

/**
 * This is the model class for table "l1v7_institution".
 *
 * @property integer $id
 * @property string $title_ua
 * @property string $title_ru
 * @property string $title_en
 * @property integer $city_id
 * @property string $web_site
 */
class Institution extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'l1v7_institution';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['title_ua', 'title_ru', 'city_id'], 'required'],
				[['city_id'], 'integer'],
				[['title_ua', 'title_ru', 'title_en', 'web_site'], 'string', 'max' => 512]
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
				'title_ua' => 'Title Ua',
				'title_ru' => 'Title Ru',
				'title_en' => 'Title En',
				'city_id' => 'City ID',
				'web_site' => 'Web Site',
		];
	}

	public static function getAll( $lang = 'ru' )
	{
		if ( NULL == $lang || $lang == 'ru' ) {

			$insts = ( new Query() )
					->select([
								'id' => 'l1v7_institution.id', 'title_en' => 'l1v7_institution.title_en', 
								'title' => 'l1v7_institution.title_ru', 'city' => 'l1v7_city.title_ru'
							])
					->from('l1v7_institution')
					->join('JOIN', 'l1v7_city', 'l1v7_institution.city_id=l1v7_city.id')
					->all();
		} else {

			$insts = ( new Query() )
					->select([
								'id' => 'l1v7_institution.id', 'title_en' => 'l1v7_institution.title_en', 
								'title' => 'l1v7_institution.title_ua', 'city' => 'l1v7_city.title_ua'
							])
					->from('l1v7_institution')
					->join('JOIN', 'l1v7_city', 'l1v7_institution.city_id=l1v7_city.id')
					->all();           
		}    

		return $insts;
	}

	public static function findByRegion ( $region, $lang = 'ru' )
	{
		if(NULL == $lang || $lang == 'ru'){
				
			$insts = ( new Query() )
					->select(['l1v7_institution.*', 'city' => 'l1v7_city.title_ru'])
					->from('l1v7_institution')
					->join('JOIN', 'l1v7_city', 'l1v7_institution.city_id=l1v7_city.id')
					->where("l1v7_city.region_id=(SELECT id FROM l1v7_region where title_en='$region')")
					->all();

		} else {
			$insts = ( new Query() )
					->select(['l1v7_institution.*', 'city' => 'l1v7_city.title_ua'])
					->from('l1v7_institution')
					->join('JOIN', 'l1v7_city', 'l1v7_institution.city_id=l1v7_city.id')
					->where("l1v7_city.region_id=(SELECT id FROM l1v7_region where title_en='$region')")
					->all();
		}

		return $insts;
	}

	public static function findByTitle($id = false, $en_title = false)
	{
		$query = new Query();
		$query->select(['l1v7_institution.*', 'city' => 'l1v7_city.title_ru'])
				->from('l1v7_institution')
				->join('JOIN', 'l1v7_city', 'l1v7_institution.city_id=l1v7_city.id');
				if ( $id != false ) {
						$query->where(['l1v7_institution.id' => $id]);
				} else{
						$query->where(['l1v7_institution.title_en' => $en_title]);
				}
		$inst = $query->one();
		
		return $inst;	
	}
	
	public static function findByDirId($id, $pageSize = 15)
	{
		$query = new Query();
		$query
				->select(['l1v7_institution.*', 'city' => 'l1v7_city.title_ru'])
				->from('l1v7_institution')
				->join('JOIN', 'l1v7_institution_direction', 'l1v7_institution.id=l1v7_institution_direction.institution_id')
				->join('JOIN', 'l1v7_city', 'l1v7_city.id=l1v7_institution.city_id')
				->where(['l1v7_institution_direction.direction_id' => $id]);
		$pagination = new Pagination([
				'defaultPageSize' => $pageSize,
				'totalCount' => $query->count(),
		]);
		$insts = $query
				->offset($pagination->offset)
				->limit($pagination->limit)
				->all();
		return [
		  'insts' => $insts,
		  'pagination' => $pagination,
		  ];			  
	}
}
