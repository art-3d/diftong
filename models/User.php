<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property integer $status
 * @property string $auth_key
 * @property string $created_at
 * @property string $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
  const STATUS_ACTIVE = 10;

  /**
   * @inheritdoc
   */
  public static function tableName()
  {
      return '{{%user}}';
  }

  /**
   * @inheritdoc
   */
  public function rules()
  {
      return [
          [['username', 'email', 'password_hash', 'status', 'auth_key'], 'required'],
          [['status'], 'integer'],
          [['created_at', 'updated_at'], 'safe'],
          [['username', 'email'], 'string', 'min' => 2, 'max' => 255],
          [['password_hash', 'auth_key'], 'string', 'max' => 60],
          [['username', 'email'], 'unique', 'targetAttribute' => ['username', 'email'], 'message' => 'The combination of Username and Email has already been taken.'],
      ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
      return [
          'id' => 'ID',
          'username' => 'Username',
          'email' => 'Email',
          'password_hash' => 'Password Hash',
          'status' => 'Status',
          'auth_key' => 'Auth Key',
          'created_at' => 'Created At',
          'updated_at' => 'Updated At',
      ];
  }
  
  public function beforeSave($insert)
  {
      if (parent::beforeSave($insert)) {
          if ($this->isNewrecord) {
            $this->created_at = time();
          } else {
            $this->updated_at = time();
          }
          return true;
      } else {
          return false;
      }
  }
  
	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username]);
	}  
	
	public static function findByEmail($email)
	{
		return static::findOne(['email' => $email]);
	}
	
	public static function findIdentity($id)
	{
		return static::findOne($id);
	}	
	
	public function setPassword($password)
	{
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}
	
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}
	
	/*  IdentityInterface */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['access_token' => $token]);
	}
	public function getId()
	{
		return $this->id;
	}
	public function getAuthKey()
	{
		return $this->auth_key;
	}
	public function validateAuthKey($authKey)
	{
		return $this->auth_key === $authKey;
	}		
}
