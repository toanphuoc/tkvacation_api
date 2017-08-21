<?php

/**
* 
*/
class BlogController extends CController
{
    public function actionGetLogImage()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

        $token = new Token();
        $t = $_GET['token'];

        $token->checkValidToken($t);

        $blog_Images = new Blog_Images();
        $model = $blog_Images->getBlogImages($_GET['id']);
        echo json_encode($model);
    }

    public function actionCreate()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

        $token = new Token();
        $t = $_GET['token'];

        $token->checkValidToken($t);

        $model = new Blog();

        $model->blog_name = $_POST['blog_name'];
        $model->overview = $_POST['overview'];
        $model->status = $_POST['status'];
        $model->date_created = date('Y-m-d');

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
                $model->blog_img = 'img/'.$filename;
            }
            else{
                echo json_encode(array('status' => false, 'message' => "Not uploaded because of error #".$_FILES["file"]["error"]));
                exit();
            }
        }else{
            echo json_encode(array('status' => false));
        }

        if($model->save()){

            $blog_Images = new Blog_Images();
            $blog_Images->url = $model->blog_img;
            $blog_Images->blog_id = $model->id;

            if($blog_Images->save()){
                echo json_encode(array('status' => true));
            }else{
                echo json_encode(array('status' => false));
            }
        }else{
            echo json_encode(array('status' => false, 'message' => 'Error when save blog.'));
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

        $model = Blog::model()->findByPk($id);
        if(is_null($model))
        {
            echo json_encode(array('status' => false, 'message' => 'Data hem co.'));
            exit();
        }

        $model->blog_name = $_POST['blog_name'];
        $model->overview = $_POST['overview'];
        $model->status = $_POST['status'];

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
                $oldImage = $_SERVER['DOCUMENT_ROOT'].'/'.$model->blog_img;

                if(file_exists($oldImage))
                {
                    unlink($oldImage);
                }

                $model->blog_img = 'img/'.$filename;
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

    public function actionChangeStatus(){
             header('Content-Type: application/json');
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
            $token = new Token();
            $t = $_GET['token'];

            $token->checkValidToken($t);

            $id = $_GET['id'];
            $model = Blog::model()->findByPk($id);
            
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

    public function actionGetList()
    {
            header('Content-Type: application/json');
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
            $token = new Token();
            $t = $_GET['token'];

            $token->checkValidToken($t);

            $currentPage = (isset($_GET['page']) ? $_GET['page'] : 1);
            $blog = new Blog();

            echo json_encode($blog->getListBlogForAdmin(10, $currentPage));
    }

	/**
        *   Get list of blog for user page
    */
    public function actionList()
	{
		header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

        $currentPage = (isset($_GET['page']) ? $_GET['page'] : 1);
        $blog = new Blog();

        echo json_encode($blog->getListBlog(6, $currentPage));
	}

        /**
        * Get blog by id
        */
	public function actionGetBlog()
	{
		header('Content-Type: application/json');
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

                $id = $_GET['id'];
                $blog = new Blog();

                echo json_encode($blog->getBlogById($id));
	}

        /**
        *       Get orther blog for user page
        */
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