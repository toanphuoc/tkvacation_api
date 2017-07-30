<?php

/**
* 
*/
class BlogController extends CController
{
	
        public function actionList()
	{
		header('Content-Type: application/json');
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

                $currentPage = (isset($_GET['page']) ? $_GET['page'] : 1);
                $blog = new Blog();

                echo json_encode($blog->getListBlog(6, $currentPage));
	}

	public function actionGetBlog()
	{
		header('Content-Type: application/json');
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

                $id = $_GET['id'];
                $blog = new Blog();

                echo json_encode($blog->getBlogById($id));
	}

        public function actionOther()
        {
                header('Content-Type: application/json');
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

                $id = $_GET['id'];
                $blog = new Blog();

                echo json_encode($blog->getOtherBlog($id));
        }
}