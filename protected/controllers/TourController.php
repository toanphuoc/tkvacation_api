<?php

/**
* 
*/
class TourController extends CController
{
	public $pageSize = 10;

	public function actionIndex(){

	}

	public function actionChangeStatus()
	{
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

		$token = new Token();
		$t = $_GET['token'];

		$token->checkValidToken($t);
		$id = $_GET['id'];

		$model = Tours::model()->findByPk($id);
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

	public function actionCreate()
	{
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

		$token = new Token();
		$t = $_GET['token'];

		$token->checkValidToken($t);

		$model = new Tours();

		$model->name = $_POST["name"];
		$model->period = $_POST["period"];
		$model->availability = $_POST["availability"];
		$model->overview = $_POST["overview"];
		$model->price = $_POST["price"];
		$model->destination_id = $_POST["destination_id"];
		$model->price_vnd = $_POST["price_vnd"];
		$model->price_detail = $_POST["price_detail"];
		$model->status = $_POST["status"];
		$model->itinerary = $_POST["itinerary"];
		$model->booking = 0;

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

	public function actionEdit()
	{
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

		$token = new Token();
		$t = $_GET['token'];

		$token->checkValidToken($t);
		$id = $_GET['id'];

		$model = Tours::model()->findByPk($id);
		if(is_null($model))
		{
			echo json_encode(array('status' => false, 'message' => 'Data hem co.'));
			exit();
		}

		$model->name = $_POST["name"];
		$model->period = $_POST["period"];
		$model->availability = $_POST["availability"];
		$model->overview = $_POST["overview"];
		$model->price = $_POST["price"];
		$model->destination_id = $_POST["destination_id"];
		$model->price_vnd = $_POST["price_vnd"];
		$model->price_detail = $_POST["price_detail"];
		$model->itinerary = $_POST["itinerary"];
		$model->status = $_POST["status"];

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

		$models = $tour->getTourById($id);

		// $data = array('tour' => $models, 'itinerary' => $itinerary->getItinerayOfTour($id));

		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		echo json_encode($models);
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