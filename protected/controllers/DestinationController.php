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
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        echo json_encode($data);
	}

	public function actionUpdate()
	{
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

		$token = new Token();
		$t = $_GET['token'];

		$token->checkValidToken($t);
		$id = $_GET['id'];

		$model = Destinations::model()->findByPk($id);
		
		$title = $_POST['title'];
		$model->title = $title;


		if(isset($_FILES['file']))
		{
			$file = $_FILES['file'];

			//Move file to img folder
			$urlBase = $_SERVER['DOCUMENT_ROOT'].'/img/';
			$filename = time().$file["name"];
			
			$Moved = move_uploaded_file($_FILES["file"]["tmp_name"], $urlBase.$filename);
			// var_dump($file);
			
			if($Moved)
			{
				//Delete old image
				$oldImage = $_SERVER['DOCUMENT_ROOT'].'/'.$model->img;

				if(file_exists($oldImage))
				{
					unlink($oldImage);
				}

				$model->img = 'img/'.$filename;
			}
			else{
				echo json_encode(array('status' => false, 'message' => 'Error when copy file updated'));;
				exit();
			}
		}

		if($model->save()){
			echo json_encode(array('status' => true));
    	}else{
    		echo json_encode(array('status' => false));
    	}
	}

	public function actionGetDestinationById()
	{
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

        $id = $_GET['id'];
        $destination = new Destinations();
		$model = $destination->getDestinationById($id);

		echo json_encode($model);
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
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
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
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		echo json_encode($data);
	}
}