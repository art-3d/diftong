<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\data\Pagination;
use yii\db\Query;

use app\models\Tech;
use app\models\Institution;
use app\models\Region;
use app\models\Direction;
use app\models\TechDirection;

class MainController extends Controller
{
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
			if(NULL == $lang || $lang == 'ru'){
				
				$insts = ( new Query() )
						->select(['l1v7_institution.*', 'city' => 'l1v7_city.title_ru'])
						->from('l1v7_institution')
						->join('JOIN', 'l1v7_city', 'l1v7_institution.city_id=l1v7_city.id')
						->where("l1v7_city.region_id=(SELECT id FROM l1v7_region where title_en='$region')")
						->all();
						
				$techs = ( new Query() )
						->select(['l1v7_tech.*', 'city' => 'l1v7_city.title_ru'])
						->from('l1v7_tech')
						->join('JOIN', 'l1v7_city', 'l1v7_tech.city_id=l1v7_city.id')
						->where("l1v7_city.region_id=(SELECT id FROM l1v7_region where title_en='$region')")
						->all();

			} else {
				$insts = ( new Query() )
						->select(['l1v7_institution.*', 'city' => 'l1v7_city.title_ua'])
						->from('l1v7_institution')
						->join('JOIN', 'l1v7_city', 'l1v7_institution.city_id=l1v7_city.id')
						->where("l1v7_city.region_id=(SELECT id FROM l1v7_region where title_en='$region')")
						->all();
						
				$techs = ( new Query() )
						->select(['l1v7_tech.*', 'city' => 'l1v7_city.title_ua'])
						->from('l1v7_tech')
						->join('JOIN', 'l1v7_city', 'l1v7_tech.city_id=l1v7_city.id')
						->where("l1v7_city.region_id=(SELECT id FROM l1v7_region where title_en='$region')")
						->all();
			}
			    
			$region = Region::find()
					->where(['title_en' => $region])
					->one();

			return $this->render('region', [
							'insts' => $insts,
							'techs' => $techs,
							'region' => $region,
					]);
		}

		public function actionIselected($id=false, $en=false)
		{
			$query = new Query();
			$query->select(['l1v7_institution.*', 'city' => 'l1v7_city.title_ru'])
					->from('l1v7_institution')
					->join('JOIN', 'l1v7_city', 'l1v7_institution.city_id=l1v7_city.id');
					if ( $id != false ) {
							$query->where(['l1v7_institution.id' => $id]);
					} else{
							$query->where(['l1v7_institution.title_en' => $en]);
					}
			$inst = $query->one();

			$query = new Query();
			$query->select('l1v7_direction.*')
					->from('l1v7_direction')
					->join('JOIN', 'l1v7_institution_direction', 'l1v7_institution_direction.direction_id=l1v7_direction.id')
					->join('JOIN', 'l1v7_institution', 'l1v7_institution_direction.institution_id=l1v7_institution.id');
					if($id!=false) {
							$query->where(['l1v7_institution.id' => $id]);
					} else{
							$query->where(['l1v7_institution.title_en' => $en]);
					}
			$directions = $query->all();

			return $this->render('iselected', [
							'inst' => $inst,
							'directions' => $directions,

					]);
		}

		public function actionTselected($id)
		{
			$tech = ( new Query() )
					->select(['l1v7_tech.*', 'city' => 'l1v7_city.title_ru'])
					->from('l1v7_tech')
					->join('JOIN', 'l1v7_city', 'l1v7_tech.city_id=l1v7_city.id')
					->where(['l1v7_tech.id' => $id])
					->one();

			$directions = ( new Query() )
					->select('l1v7_tech_direction.*')
					->from('l1v7_tech_direction')
					->join('JOIN', 'l1v7_tech_tech_direction', 'l1v7_tech_tech_direction.tech_direction_id=l1v7_tech_direction.id')
					->join('JOIN', 'l1v7_tech', 'l1v7_tech_tech_direction.tech_id=l1v7_tech.id')
					->where(['l1v7_tech.id' => $id])
					->all();

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
