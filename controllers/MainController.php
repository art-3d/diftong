<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\data\Pagination;
use yii\db\Query;
use yii\db\Command;

use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

use app\models\Region;
use app\models\Institution;
use app\models\InstitutionDirection;
use app\models\Direction;
use app\models\InstitutionSubject;
use app\models\Tech;
use app\models\TechDirection;
use app\models\TechSubject;

class MainController extends Controller
{

	public function __construct($id, $module, $config = [])
	{
    
	    $response = Yii::$app->response;
	    
	    $response->on($response::EVENT_BEFORE_SEND, function($event) {
	    });
    
		parent::__construct($id, $module, $config);	
	}

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
		if ($instance == 'inst') { // institutions
			if($id){
       			 $data = Institution::findByDirId($id);       
				$direction = Direction::find()
						->where(['id' => $id])
						->one();
				return $this->render('inst_direction', [
								'direction' => $direction,
								'insts' => $data['insts'],
								'pagination' => $data['pagination'],
						]);
						
			} else { // directions of colleges
        			$inst_directions = InstitutionDirection::getAll();
				return $this->render('inst_directions', ['inst_directions' => $inst_directions]);                    
			}
		} elseif ($instance == 'tech') { // technicums
			if($id){
       			 $data = Tech::findByDirId($id);						
				$direction = Direction::find()
						->where(['id' => $id])
						->one();
				return $this->render('tech_direction', [
								'direction' => $direction,
								'techs' => $data['techs'],
								'pagination' => $data['pagination'],
						]);
						
			} else { // directions of technicums
        			$tech_directions = TechDirection::getAll();   
				return $this->render('tech_directions', ['tech_directions' => $tech_directions]);
				
			}
		}  
		
		// list of directions				
    		$tech_directions = TechDirection::getAll();
		$inst_directions = InstitutionDirection::getAll();			
		return $this->render('all_directions', [
						'inst_directions' => $inst_directions,
						'tech_directions' => $tech_directions,
				]);
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
