<?php

/**
* 
*/
class TourController extends CController
{
	public $pageSize = 10;

	public function actionIndex(){

	}

	public function actionSearchTour(){

		$currentPage = (isset($_GET['page']) ? $_GET['page'] : 1);
		$keySearch = isset($_GET['keySearch']) && $_GET['keySearch'] != 'undefined' ? $_GET['keySearch'] : NULL;

		if(isset($_GET['desId']) && $_GET['desId'] != 'undefined'){
			$desId = $_GET["desId"];
		}else{
			$desId = NULL;
		}

		if(isset($_GET['periodMin']) && $_GET['periodMin'] != 'undefined'){
			$pMin = $_GET["periodMin"];
		}else{
			$pMin = NULL;
		}

		if(isset($_GET['periodMax']) && $_GET['periodMax'] != 'undefined'){
			$pMax = $_GET["periodMax"];
		}else{
			$pMax = NULL;
		}

		if(isset($_GET['priceMin']) && $_GET['priceMin'] != 'undefined'){
			$priceMin = $_GET["priceMin"];
		}else{
			$priceMin = NULL;
		}

		if(isset($_GET['priceMax']) && $_GET['priceMax'] != 'undefined'){
			$priceMax = $_GET["priceMax"];
		}else{
			$priceMax = NULL;
		}

		$tour = new Tours();
		$data = $tour->search($keySearch, $desId, $pMin, $pMax, $priceMin, $priceMax, $currentPage);
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		echo json_encode($data);
	}

	public function actionGetList(){

		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

		$token = new Token();
        $t = $_GET['token'];

        $token->checkValidToken($t);

		$tours = new Tours();
		$currentPage = (isset($_GET['page']) ? $_GET['page'] : 1);
		
		$models = $tours->getList(15, $currentPage);
		
		echo json_encode($models);
	}

	public function actionGetTourByDestination(){
		$tour = new Tours();
		$destination = new Destinations();

		$id = $_GET['id'];

		$models = $tour->getTourInDestination($id);

		$data = array('data' => $models, 'des' => $destination->getDestinationById($id));

		
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		echo json_encode($data);
	}

	public function actionGetPopularTour(){
		$tour = new Tours();
		$models = $tour->getPopularTour(4);
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		echo json_encode($models);
	}

	public function actionGetTourById(){
		$id = $_GET['id'];

		$tour = new Tours();
		$itinerary = new Itinerary();

		$data = array();

		$models = $tour->getTourById($id);

		$data = array('tour' => $models, 'itinerary' => $itinerary->getItinerayOfTour($id));

		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		echo json_encode($data);
	}

	/**
		*	Order tour by destination 
	*/
	public function actionTourByDestination()
	{
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

        $token = new Token();
        $t = $_GET['token'];

        $token->checkValidToken($t);

        $currentPage = (isset($_GET['page']) ? $_GET['page'] : 1);

        $desId = $_GET['destinationId'];

        $tour = new Tours();
        $model = $tour->getListByDestination($desId, 15, $currentPage);
        echo json_encode($model);
	}
}