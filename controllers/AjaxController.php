<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

use app\models\Region;
use app\models\Institution;
use app\models\Direction;
use app\models\InstitutionSubject;
use app\models\Tech;
use app\models\TechDirection;
use app\models\TechSubject;

class AjaxController extends Controller
{
	public function actionGetInst()
	{
		if( !Yii::$app->request->isAjax) {
			throw new \yii\web\NotFoundHttpException('The request must be Ajax');
		}

		Yii::$app->response->format = Response::FORMAT_JSON;
		$lang = Yii::$app->request->cookies['lang'];

		$techs = Tech::getAll($lang);
		$insts = Institution::getAll($lang);

		return ['techs' => $techs, 'insts' => $insts];				
	}

	public function actionGetSubject()
	{
		if (!Yii::$app->request->isAjax) {
			throw new \yii\web\NotFoundHttpException('The request must be Ajax');
		}

		Yii::$app->response->format = Response::FORMAT_JSON;

		$direction_id = Yii::$app->request->get('direct');

		if ( $title_en = Yii::$app->request->get('title_en') ) {
			$subjects = InstitutionSubject::findByDirection($direction_id, $title_en);

		} elseif ($inst_id = Yii::$app->request->get('inst') ) {
			$subjects = InstitutionSubject::findByDirection($direction_id, $inst_id);

		} elseif ($tech_id = Yii::$app->request->get('tech') ) {
			$subjects = TechSubject::findByDirection($direction_id, $tech_id);

		} else {
			throw new NotFoundHttpException('The route does not exist');
		}

		return $subjects;
	}

	public function actionGetFile()
	{
		if( !Yii::$app->request->isAjax) {
			throw new \yii\web\NotFoundHttpException('The request must be Ajax');
		}

		Yii::$app->response->format = Response::FORMAT_JSON;

		$subject_id = Yii::$app->request->post('id');
		$pathname = Yii::$app->request->post('pathname');

		if ( preg_match('/^\/tech/', $pathname) ) { // tech
			$tech_id = str_replace('/tech/', '', $pathname);
			return ['tech_id' => $tech_id];
			//$files = TechSubject::getFiles($)
		} else { // inst

		}

		return ['id' => $subject_id, 'pathname' => $pathname];
	}

	public function actionAddSubject()
	{
		if( !Yii::$app->request->isAjax) {
			throw new \yii\web\NotFoundHttpException('The request must be Ajax');
		}

		Yii::$app->response->format = Response::FORMAT_JSON;

		$lang = Yii::$app->request->cookies['lang'];
		$title_row = $lang == 'ua' ? 'title_ua' : 'title_ru';
		$direction_id = Yii::$app->request->get('direct');

		$subject_title = Yii::$app->request->get('title');


		if ( $title_en = Yii::$app->request->get('title_en') ) {
			$row = (new Query)->select('id')->from('l1v7_institution')->where(['title_en' => $title_en])->one();
			$institution_id = $row['id'];
			$entity = new InstitutionSubject();
			$entity->institution_id = $institution_id;

		} elseif ($inst_id = Yii::$app->request->get('inst_id') ) {
			$entity = new InstitutionSubject();
			$entity->institution_id = $inst_id;

		} elseif ($tech_id = Yii::$app->request->get('tech_id') ) {
			$entity = new TechSubject();
			$entity->tech_id = $tech_id;

		} else {
			throw new NotFoundHttpException('The route does not exist');
		}

		$entity->$title_row = $subject_title;
		$entity->direction_id = $direction_id;
		$entity->created = time();		
		$entity->save();
	}  
}
