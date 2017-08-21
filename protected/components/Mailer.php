<?php

// include __DIR__ .'../../library/PHPMailer/PHPMailerAutoload.php';
include __DIR__ . '/../library/PHPMailer/PHPMailerAutoload.php';

/**
* 
*/
class Mailer
{
	
	public static function sendOne($from = array(), $email_notify, $subject, $message)
	{
		$mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;

        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;

        $mail->Username = "tkvacation2017@gmail.com";
        $mail->Password = "Tuankhanh2017";

        $mail->setFrom($from[0], $from[1]);

        if(empty($email_notify))
        {
        	 return array('type' => 'error', 'message' => 'Email notification is empty.');
        }else{
        	foreach ($email_notify as $key => $value) {
        		 $mail->addAddress($value->email, $value->first_name.' '.$value->last_name);
        	}
        }

        $mail->Subject = $subject;
        $mail->msgHTML($message);
        $mail->isHTML(true);      
        $mail->AltBody = 'This is a plain-text message body';
        //send the message, check for errors
        if (!$mail->send()) {
            return array('type' => 'error', 'message' => $mail->ErrorInfo);
        } else {
           return array('type' => 'success', 'message' => 'Message sent.');
        }
	}
}