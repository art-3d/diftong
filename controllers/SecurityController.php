<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

use app\models\User;
use app\models\RegForm;
use app\models\LoginForm;

class SecurityController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' 	=> AccessControl::className(),
				'only' 	=> ['login', 'logout', 'signup', 'forgot-password'],
				'rules' 	=> [
					[
						'allow'		=> true,
						'actions' 	=> ['login', 'signup', 'forgot-password'],
						'roles' 		=> ['?'],
					],
					[
						'allow'		=> true,
						'actions'	=> ['logout'],
						'roles'		=> ['@'],
					],
				],
				'denyCallback' => function($rule, $action) {
				  throw new \Exception('You are not allowed to access this page');
				},
			],
		];
	}

	public function actionLogin()
	{
	  $model = new LoginForm();
	  
	  if (!Yii::$app->user->isGuest) {
	    return $this->goHome();
	  }
	  
	  if (Yii::$app->request->isPost) {
	    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	    
	    $model->username = Yii::$app->request->post('login');
	    $model->password = Yii::$app->request->post('password');
	    $model->rememberMe = Yii::$app->request->post('remember_me') == '1' ? true : false;
	    
	    if ( $model->login() ) {
	      return ['status' => true];
	    }
	    
	    return ['status' => false, 'errors' => $model->errors];
	  }
	  
	  return $this->render('login');
	}

	public function actionSignup()
	{
	  $model = new RegForm();
	  
	  if (Yii::$app->request->isPost) {
	    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	    
	    $model->username = Yii::$app->request->post('login');
	    $model->email    = Yii::$app->request->post('email');
	    $model->password = Yii::$app->request->post('password');
	    	    
	    if ($model->validate()) {
	      if ($model->reg() ) return ['status' => true];	     
	    }
	    
      return ['status' => false, 'errors' => $model->errors];   	    
	  }
	  
	  return $this->render('signup');
	}

	public function actionLogout()
	{
  	Yii::$app->user->logout();	
  	
	  if (Yii::$app->request->isPost) {
	    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;	    
	    return ['status' => true];
	  }
	  return $this->goHome();
	}
	
	public function actionForgotPassword()
	{
	  
	  return $this->render('forgot-password');
	}
	
}
