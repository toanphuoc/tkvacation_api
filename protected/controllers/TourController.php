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

		if(isset($_GET['keySearch'])){
			$keySearch = $_GET["keySearch"];
		}else{
			$keySearch = NULL;
		}

		if(isset($_GET['desId'])){
			$desId = $_GET["desId"];
		}else{
			$desId = NULL;
		}

		if(isset($_GET['periodMin'])){
			$pMin = $_GET["periodMin"];
		}else{
			$pMin = NULL;
		}

		if(isset($_GET['periodMax'])){
			$pMax = $_GET["periodMax"];
		}else{
			$pMax = NULL;
		}

		if(isset($_GET['priceMin'])){
			$priceMin = $_GET["priceMin"];
		}else{
			$priceMin = NULL;
		}

		if(isset($_GET['priceMax'])){
			$priceMax = $_GET["priceMax"];
		}else{
			$priceMax = NULL;
		}
		

		$tour = new Tours();
		$data = $tour->search($keySearch, $desId, $pMin, $pMax, $priceMin, $priceMax);
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function actionGetList(){
		$tours = new Tours();
		$currentPage = $_GET['currenetPage'];
		$models = $tours->getList(5, $currentPage);
		echo json_encode($models);
	}

	public function actionGetTourByDestination(){
		$tour = new Tours();
		$destination = new Destinations();

		$id = $_GET['id'];

		$models = $tour->getTourInDestination($id);

		$data = array('data' => $models, 'des' => $destination->getDestinationById($id));

		
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function actionGetPopularTour(){
		$tour = new Tours();
		$models = $tour->getPopularTour(4);
		header('Content-Type: application/json');
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
		echo json_encode($data);
	}
}