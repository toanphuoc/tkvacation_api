<?php

/**
* 
*/
class TourController extends CController
{
	
	public function actionIndex(){

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
		$models = $tour->getPopularTour();
		header('Content-Type: application/json');
		echo json_encode($models);
	}

	public function actionGetTourById(){
		$id = $_GET['id'];

		$tour = new Tours();
		$models = $tour->getTourById($id);
		header('Content-Type: application/json');
		echo json_encode($models);
	}
}