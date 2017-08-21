<?php

/**
* 
*/
class DestinationController extends CController
{

	public function actionIndex(){

	}

	/**
		* Get all destination 
	*/
	public function actionList(){

		//Check access token
		$token = new Token();
		$t = $_GET['token'];

		$token->checkValidToken($t);

		$destination = new Destinations();

		$models = $destination->getAll();

		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        echo json_encode($models);
	}

	/**
		* Get all available destination
	*/
	public function actionListAvailable()
	{
		$destination = new Destinations();
		$tour = new Tours();

		$models = $destination->getAvailableDestination();

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

	/**
		* Change status destination
	*/
	public function actionChangeStatus()
	{
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

		$token = new Token();
		$t = $_GET['token'];

		$token->checkValidToken($t);
		$id = $_GET['id'];

		$model = Destinations::model()->findByPk($id);
		if(is_null($model))
		{
			echo json_encode(array('status' => false, 'message' => 'Data hem co.'));
			exit();
		}

		$status = $_GET['status'];
		$model->status = $status;

		if($model->save()){
			echo json_encode(array('status' => true));
    	}else{
    		echo json_encode(array('status' => false));
    	}
	}

	/**
		* Create destination
	*/
	public function actionCreate()
	{
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

		$token = new Token();
		$t = $_GET['token'];

		$token->checkValidToken($t);

		$model = new Destinations();

		$title = $_POST['title'];
		$model->title = $title;

		$status = $_POST['status'];
		$model->status = $status;

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

			$model->img = 'img/'.$filename;
		}
		else{
			echo json_encode(array('status' => false, 'message' => "Not uploaded because of error #".$_FILES["file"]["error"]));
			exit();
		}

		if($model->save()){
			echo json_encode(array('status' => true));
    	}else{
    		echo json_encode(array('status' => false));
    	}
	}

	/**
		*	Update information of destination
		*
	*/
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
		if(is_null($model))
		{
			echo json_encode(array('status' => false, 'message' => 'Data hem co.'));
			exit();
		}
		
		$title = $_POST['title'];
		$model->title = $title;

		$status = $_POST['status'];
		$model->status = $status;

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
				echo json_encode(array('status' => false, 'message' => "Not uploaded because of error #".$_FILES["file"]["error"]));
				exit();
			}
		}

		if($model->save()){
			echo json_encode(array('status' => true));
    	}else{
    		echo json_encode(array('status' => false));
    	}
	}

	/**
		* Get destination by primary key
	*/
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

	/**
		* Get all available destinations expection one 
	*/
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

	/**
		* Get popular destinations
	*/
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