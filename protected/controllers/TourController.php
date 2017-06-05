<?php

/**
* 
*/
class TourController extends CController
{
	public $pageSize = 10;

	public function actionIndex(){

	}

	public function actionGetList(){
		$tours = new Tours();
		$currentPage = $_GET['currenetPage'];
		$models = $tours->getList(1, $currentPage);
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