<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\data\Pagination;
use yii\db\Query;
use yii\db\Command;

use yii\web\NotFoundHttpException;

use app\models\Region;
use app\models\Institution;
use app\models\Direction;
use app\models\InstitutionSubject;
use app\models\Tech;
use app\models\TechDirection;
use app\models\TechSubject;

class MainController extends Controller
{
/*
	public function __construct()
	{
		
		$service = new  \nodge\eauth\ServiceBase();

		die;
	}
*/
	
	public function actionIndex()
	{
		
		$tech_directions = TechDirection::getAll();
		$inst_directions = Direction::getAll();					
		$regions = Region::getAll();

		return $this->render('index', [
			'regions' => $regions,
			'tech_directions' => $tech_directions,
			'inst_directions' => $inst_directions,
		]);
	}

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
		if( !Yii::$app->request->isAjax) {
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

	public function actionSearch()
	{
			$query = yii::$app->request->get('inst');

			return $this->render('search',[
							'inst' => $query,
							's' => 's',
					]);
	}

	public function actionDirections( $instance=false, $id=false )
	{
		if ($instance == 'inst') { // colleges
			if($id){

				$query = new Query();
				$query
						->select(['l1v7_institution.*', 'city' => 'l1v7_city.title_ru'])
						->from('l1v7_institution')
						->join('JOIN', 'l1v7_institution_direction', 'l1v7_institution.id=l1v7_institution_direction.institution_id')
						->join('JOIN', 'l1v7_city', 'l1v7_city.id=l1v7_institution.city_id')
						->where(['l1v7_institution_direction.direction_id' => $id]);
				$pagination = new Pagination([
						'defaultPageSize' => 15,
						'totalCount' => $query->count(),
				]);
				$insts = $query
						->offset($pagination->offset)
						->limit($pagination->limit)
						->all();

				$direction = Direction::find()
						->where(['id' => $id])
						->one();

				return $this->render('inst_direction', [
								'direction' => $direction,
								'insts' => $insts,
								'pagination' => $pagination,
						]);
			} else { // list of directions of colleges
				$query = new Query();
				$inst_directions = $query
						->select(['l1v7_direction.*', 'count' => 'count(l1v7_institution.id)'])
						->from('l1v7_direction')
						->join('JOIN', 'l1v7_institution_direction', 'l1v7_institution_direction.direction_id=l1v7_direction.id')
						->join('JOIN', 'l1v7_institution' , 'l1v7_institution_direction.institution_id=l1v7_institution.id')
						->groupBy('l1v7_direction.id')
						->orderBy('count DESC')
						->all();

						return $this->render('inst_directions', [
										'inst_directions' => $inst_directions,
								]);                    
			}

		} elseif ($instance == 'tech') { // technicums
			if($id){
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
				$direction = Direction::find()
						->where(['id' => $id])
						->one();

				return $this->render('tech_direction', [
								'direction' => $direction,
								'techs' => $techs,
								'pagination' => $pagination,
						]);
			} else { // list of directions of technicums
				$query = new Query();
				$tech_directions = $query
						->select(['l1v7_tech_direction.*', 'count' => 'count(l1v7_tech.id)'])
						->from('l1v7_tech_direction')
						->join('JOIN', 'l1v7_tech_tech_direction', 'l1v7_tech_tech_direction.tech_direction_id=l1v7_tech_direction.id')
						->join('JOIN', 'l1v7_tech' , 'l1v7_tech_tech_direction.tech_id=l1v7_tech.id')
						->groupBy('l1v7_tech_direction.id')
						->orderBy('count DESC')
						->all();

						return $this->render('tech_directions', [
										'tech_directions' => $tech_directions,
								]);
			}

		} else { // list of directions

			$tech_directions = ( new Query() )
					->select(['l1v7_tech_direction.*', 'count' => 'count(l1v7_tech.id)'])
					->from('l1v7_tech_direction')
					->join('JOIN', 'l1v7_tech_tech_direction', 'l1v7_tech_tech_direction.tech_direction_id=l1v7_tech_direction.id')
					->join('JOIN', 'l1v7_tech' , 'l1v7_tech_tech_direction.tech_id=l1v7_tech.id')
					->groupBy('l1v7_tech_direction.id')
					->orderBy('count DESC')
					->all();

			$inst_directions = ( new Query() )
					->select(['l1v7_direction.*', 'count' => 'count(l1v7_institution.id)'])
					->from('l1v7_direction')
					->join('JOIN', 'l1v7_institution_direction', 'l1v7_institution_direction.direction_id=l1v7_direction.id')
					->join('JOIN', 'l1v7_institution' , 'l1v7_institution_direction.institution_id=l1v7_institution.id')
					->groupBy('l1v7_direction.id')
					->orderBy('count DESC')
					->all();

			return $this->render('all_directions', [
							'inst_directions' => $inst_directions,
							'tech_directions' => $tech_directions,
					]);

		}
	}

	public function actionRegion()
	{
		preg_match('/[-a-z]+/i', yii::$app->request->getUrl(), $matches);
		$region = $matches[0];

		$lang = Yii::$app->request->cookies['lang'];

		$insts = Institution::findByRegion($region, $lang);
		$techs = Tech::findByRegion($region, $lang);

		$region = Region::find()
				->where(['title_en' => $region])
				->one();

		return $this->render('region', [
						'insts' => $insts,
						'techs' => $techs,
						'region' => $region,
				]);
	}

	public function actionIselected($id=false, $en_title=false)
	{
		$inst = Institution::findByTitle($id, $en_title);
		$directions = Direction::findByTitle($id, $en_title);

		if ( empty($inst) ) throw new NotFoundHttpException('Institution not found!');

		return $this->render('iselected', [
						'inst' => $inst,
						'directions' => $directions,

				]);
	}

	public function actionTselected($id)
	{
		$tech = Tech::findById($id);	
		$directions = TechDirection::findById($id);		

		if ( empty($tech) ) throw new NotFoundHttpException('Technicum not found!');

		return $this->render('tselected', [
						'tech' => $tech,
						'directions' => $directions,

				]);
	}

	public function actionInst()
	{
		$query = Institution::find();
		if($city_id = yii::$app->request->get('city')){
				$query = $query->where("city_id=$city_id");
		}

		$pagination = new Pagination([
						'defaultPageSize' => 15,
						'totalCount' => $query->count(),
				]);

		$insts = $query
				->with('city')
				->offset($pagination->offset)
				->limit($pagination->limit)
				->orderBy('title_ru')
				->all();

		return $this->render('inst', [
						'insts' => $insts,
						'pagination' => $pagination,
				]);
	}

	public function actionTech( $id=false )
	{
		$query = Tech::find();
		
		if($city_id = yii::$app->request->get('city')){
				$query = $query->where("city_id=$city_id");
		}

		$pagination = new Pagination([
						'defaultPageSize' => 15,
						'totalCount' => $query->count(),
				]);

		$techs = $query
				->with('city')
				->offset($pagination->offset)
				->limit($pagination->limit)
				->orderBy('title_ru')
				->all();

		return $this->render('tech', [
						'techs' => $techs,
						'pagination' => $pagination,
				]);
	}    

	public function actionFeedback()
	{
			return $this->render('feedback');
	}

	public function actionAbout()
	{
			return $this->render('about');
	}

}
