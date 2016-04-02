<?php

namespace app\models;

use Yii;

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
}
