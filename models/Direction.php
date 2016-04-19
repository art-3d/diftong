<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "l1v7_direction".
 *
 * @property integer $id
 * @property string $title_ua
 * @property string $title_ru
 */
class Direction extends \yii\db\ActiveRecord
{
		/**
		 * @inheritdoc
		 */
		public static function tableName()
		{
				return 'l1v7_direction';
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
			$inst_directions = (new Query())
					->select(['l1v7_direction.*', 'count' => 'count(l1v7_institution.id)'])
					->from('l1v7_direction')
					->join('JOIN', 'l1v7_institution_direction', 'l1v7_institution_direction.direction_id=l1v7_direction.id')
					->join('JOIN', 'l1v7_institution' , 'l1v7_institution_direction.institution_id=l1v7_institution.id')
					->groupBy('l1v7_direction.id')
					->orderBy('count DESC')
					->all();
					
			return $inst_directions;
		}

		public static function findByTitle($id = false, $en_title = false) {
			$query = new Query();
			$query->select('l1v7_direction.*')
					->from('l1v7_direction')
					->join('JOIN', 'l1v7_institution_direction', 'l1v7_institution_direction.direction_id=l1v7_direction.id')
					->join('JOIN', 'l1v7_institution', 'l1v7_institution_direction.institution_id=l1v7_institution.id');
					if($id!=false) {
							$query->where(['l1v7_institution.id' => $id]);
					} else{
							$query->where(['l1v7_institution.title_en' => $en_title]);
					}
			$directions = $query->all();

			return $directions;
		}
}
