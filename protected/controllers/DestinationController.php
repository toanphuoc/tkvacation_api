<?php

/**
* 
*/
class DestinationController extends CController
{

	public function actionIndex(){

	}

	public function actionList(){
		$destination = new Destinations();
		$tour = new Tours();

		$models = $destination->getAll();

		$data = array();
		foreach ($models as $model) {
			$totalTours = count($tour->getTourInDestination($model->id));

			$data[] = array('des' => $model, 'totalTours' => $totalTours);
		}
		header('Content-Type: application/json');
        echo json_encode($data);
	}

	public function actionGetOtherDestination(){
		$destination = new Destinations();
		$tour = new Tours();

		$id = $_GET['id'];
		$models = $destination->getOtherDestination($id);

		$data = array();
		foreach ($models as $model) {
			$totalTours = count($tour->getTourInDestination($model->id));

			$data[] = array('des' => $model, 'totalTours' => $totalTours);
		}
		header('Content-Type: application/json');
        echo json_encode($data);
	}

	public function actionGetPopularDestination(){

		$destination = new Destinations();
		$tour = new Tours();
		$models = $destination->popularDestination();

		$data = array();
		foreach ($models as $model) {
			$totalTours = count($tour->getTourInDestination($model->id));

			$data[] = array('des' => $model, 'totalTours' => $totalTours);
		}

		header('Content-Type: application/json');
		echo json_encode($data);
	}
}