<?php

/**
* 
*/
class TourController extends CController
{
	
	public function actionIndex(){

	}

	public function actionGetTourByDestination(){
		$id = $_GET['id'];

		$tour = new Tours();
		$models = $tour->getTourInDestination($id);
		header('Content-Type: application/json');
		echo json_encode($models);
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