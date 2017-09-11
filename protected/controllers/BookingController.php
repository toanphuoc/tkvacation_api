<?php

/**
* 
*/
class BookingController extends CController
{
	
    public function actionDelete()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

        $token = new Token();
        $t = $_GET['token'];

        $token->checkValidToken($t);
        $id = $_GET['id'];

        $model = Booking::model()->findByPk($id);

        if($model->delete())
        {
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
		$model = new Booking();
		foreach($_POST as $var=>$value) {
        // Does the model have this attribute? If not raise an error
	        if($model->hasAttribute($var))
	            $model->$var = $value;
    	}

        $model->is_check = 0;
        $model->title = $_POST["title"];

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $model->date_created = date("Y-m-d h:i:s");

    	if($model->save()){

            $tour_id = $model->tour_id;
            $tour = Tours::model()->findByPk($tour_id);

            $tour->booking = $tour->booking + 1;
            $tour->save();

            $sendMail = $this->sendMailNotify($model);

    		echo json_encode(array('status' => true, 'message' => $sendMail));
    	}else{
    		echo json_encode(array('status' => false));
    	}
	}

    public function sendMailNotify($model)
    {
        //Send email
        $from = $this->getEmailForm();

        $email_notify = Email_Notification::model()->findAll();

        // $to = array($model->email, $model->first_name.' '.$model->last_name);

        $subject = '[tkvacation] - New booking';
        $message = $this->getHtmlEmailTemplate($model);

        //Send email to notify administrator
        $sendMail = Mailer::sendOne($from, $email_notify, $subject, $message);

        if(strcasecmp($sendMail['type'],'error') == 0)
        {
             $sendMail = Mailer::sendOne($from, $email_notify, $subject, $message);
        }

        //Send mail to notify client

        $email_notify_to_customer = new Email_Notification();
        $email_notify_to_customer->email = $model->email;
        $email_notify_to_customer->first_name = $model->first_name;
        $email_notify_to_customer->last_name = $model->last_name;

        $arr = array($email_notify_to_customer);

        $sendMailToClient = Mailer::sendOne($from, $arr, "Thank you for booking with us.", $this->getHtmlEmailTemplateToClient($model));

        return $sendMail;
    }

    public function getHtmlEmailTemplateToClient($model)
    {
        $t = $model->title == '1' ? 'Mr': 'Mrs';
        $title = $t.' '.$model->first_name.' '.$model->last_name;
        $emailTemplate = "<!DOCTYPE html>
        <html>
        <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title></title>
        <style type='text/css'>
        td{
            padding: 5px 10px;
        }

        a{
            text-decoration: none;
        }

        @font-face {
            font-family: 'Source Sans Pro'; font-style: normal; font-weight: 400; src: local('Source Sans Pro'), local('SourceSansPro-Regular'), url('http://fonts.gstatic.com/s/sourcesanspro/v8/ODelI1aHBYDBqgeIAH2zlNzbP97U9sKh0jjxbPbfOKg.ttf') format('truetype');
        }
        </style>
        </head>
        <body>
            <p>Dear ".$title.",</p>
            <p>Your booking has been sent. We are processing your booking and respond to you as soon as possible. Thank you for booking with us.</p>
            <p>This email is sent via TK Vacation <a href='www.tkvacation.com'>www.tkvacation.com</a>.</p>
            <p>Thanks and best regards.<br/>TK Vacation</p>
            
        </body>
        </html>";

        return $emailTemplate;
    }

    public function getHtmlEmailBody($model)
    {
        $tour = Tours::model()->findByPk($model->tour_id);

        $url = $_SERVER['SERVER_NAME']."/#!/tour/".$tour->id;

        $title = "Mr.";

        if($model->title == '2'){
            $title = "Mrs.";
        }

        $emailBody = "
            <h3><strong>Tour name: </strong><a href='".$url."'>".$tour->name."</a></h3>
            <h3 style='margin-bottom:15px;'>New booking information</h3>
            <table border='1'>
            <tr>
                <td><strong>Title</strong></td>
                <td style='font-weight:500;'>".$title."</td>
            </tr>
            <tr>
                <td><strong>First Name</strong></td>
                <td style='font-weight:500;'>".$model->first_name."</td>
            </tr>
            <tr>
                <td><strong>Last Name</strong></td>
                <td style='font-weight:500;'>".$model->last_name."</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td style='font-weight:500;'>".$model->email."</td>
            </tr>
            <tr>
                <td><strong>Phone number</strong></td>
                <td style='font-weight:500;'>".$model->phone."</td>
            </tr>
            <tr>
                <td><strong>Nationality</strong></td>
                <td style='font-weight:500;'>".$model->country."</td>
            </tr>
             <tr>
                <td><strong>Start date</strong></td>
                <td style='font-weight:500;'>".$model->start_date."</td>
            </tr>
            <tr>
                <td><strong>Number of people</strong></td>
                <td style='font-weight:500;'>".$model->number_of_people."</td>
            </tr>
            <tr>
                <td><strong>Note</strong></td>
                <td style='font-weight:500;'>".$model->note."</td>
            </tr>
        </table>";

        return $emailBody;
    }

       /*
        get email template
    */
    public function getHtmlEmailTemplate($model){
        $emailTemplate = "<!DOCTYPE html>
        <html>
        <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title></title>
        <style type='text/css'>
        td{
            padding: 5px 10px;
        }

        a{
            text-decoration: none;
        }

        @font-face {
            font-family: 'Source Sans Pro'; font-style: normal; font-weight: 400; src: local('Source Sans Pro'), local('SourceSansPro-Regular'), url('http://fonts.gstatic.com/s/sourcesanspro/v8/ODelI1aHBYDBqgeIAH2zlNzbP97U9sKh0jjxbPbfOKg.ttf') format('truetype');
        }
        </style>
        </head>
        <body style='margin: 0; padding: 0;'>"
           .$this->getHtmlEmailBody($model).
        '</body>
        </html>';

        return $emailTemplate;
    }

    public function getEmailForm()
    {
        // return array('tkvacation2017@gmail.com', 'Tkvacation');
        return array('contact@tkvacation.com', 'TK Vacation');
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
        $booking = new Booking();

        echo json_encode($booking->getList(15, $currentPage));
	}

	public function actionGetBookingById()
	{
		header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

        $token = new Token();
        $t = $_GET['token'];

        $token->checkValidToken($t);

        $id = $_GET['id'];

        $model = Booking::model()->findByPk($id);

        if($model->is_check == '0')
        {
            $model->is_check = '1';
            $model->save();
        }

        // $tour = new Tours();
        $model->tour_id = Tours::model()->findByPk($model->tour_id);
        echo json_encode($model);
	}
}