<?php

namespace app\models;

use Yii;

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
class User extends \yii\db\ActiveRecord
{
	/**
	 * @var array EAuth attributes
	 */
	public $profile;

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
            [['username', 'email'], 'string', 'max' => 255],
            [['password_hash', 'auth_key'], 'string', 'max' => 32],
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

    /* EAuth */

    public static function findByUsername($username)
    {
    	return static::findOne([
    		'username'	=> $username
    	]);
    }

    public static function findIdentity($id)
    {
    	if (Yii::$app->getSession()->has('user-'.$id)) {
    		return new self(Yii::$app->getSession()->get('user-'.$id));
    	} else {
    		return isset(self::$users[$id]) ? new self(self::$users[$id]) : null;
    	}
    }

    /**
     * @param \nodge\eauth\ServiceBase $service
     * @return User
     * @throws ErrorException
     */
    public static function findByEauth($service)
    {
    	if (!$service->getIsAuthenticated()) {
    		throw new ErrorException('EAuth user should be authenticated before creating identity.');
    	}

    	$id = $service->getService().'-'.$service->getId();
       $attributes = [
          'id' => $id,
          'username' => $service->getAttribute('name'),
          'authKey' => md5($id),
          'profile' => $service->getAttributes(),
      ];
      $attributes['profile']['service'] = $service->getServiceName();
      Yii::$app->getSession()->set('user-'.$id, $attributes);
      return new self($attributes);   	
    }

}
