<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "l1v7_institution_direction".
 *
 * @property integer $institution_id
 * @property integer $direction_id
 */
class InstitutionDirection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'l1v7_institution_direction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['institution_id', 'direction_id'], 'required'],
            [['institution_id', 'direction_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'institution_id' => 'Institution ID',
            'direction_id' => 'Direction ID',
        ];
    }
    
    public function getAll()
    {
       $directions = ( new Query() )
					->select(['l1v7_direction.*', 'count' => 'count(l1v7_institution.id)'])
					->from('l1v7_direction')
					->join('JOIN', 'l1v7_institution_direction', 'l1v7_institution_direction.direction_id=l1v7_direction.id')
					->join('JOIN', 'l1v7_institution' , 'l1v7_institution_direction.institution_id=l1v7_institution.id')
					->groupBy('l1v7_direction.id')
					->orderBy('count DESC')
					->all();
					
		  return $directions;
    }
}
