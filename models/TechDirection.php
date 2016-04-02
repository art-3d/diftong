<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%tech_direction}}".
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $title_ua
 */
class TechDirection extends \yii\db\ActiveRecord
{
		/**
		 * @inheritdoc
		 */
		public static function tableName()
		{
			return '{{%tech_direction}}';
		}

		/**
		 * @inheritdoc
		 */
		public function rules()
		{
			return [
					[['title_ru', 'title_ua'], 'required'],
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
			];
		}
		
		public static function getAll()
		{
			$tech_directions = (new Query())
					->select(['l1v7_tech_direction.*', 'count' => 'count(l1v7_tech.id)'])
					->from('l1v7_tech_direction')
					->join('JOIN', 'l1v7_tech_tech_direction', 'l1v7_tech_tech_direction.tech_direction_id=l1v7_tech_direction.id')
					->join('JOIN', 'l1v7_tech' , 'l1v7_tech_tech_direction.tech_id=l1v7_tech.id')
					->groupBy('l1v7_tech_direction.id')
					->orderBy('count DESC')
					->all();
					
			return 	$tech_directions;				
		}
}
