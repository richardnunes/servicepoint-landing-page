<?php
/**
 * Created by PhpStorm.
 * User: Roberto
 * Date: 10-04-2014
 * Time: 14:42
 */

include 'libs/SendGrid_loader.php';
$myemail = 'servicepoint.sp@gmail.com';
$file = 'logs/mail-callback';
$now = date("M j G:i:s T Y");

$data = json_decode($_POST['mandrill_events'],true);

/*ob_start();
var_dump($data[0]['msg']['email']);
$varDump = ob_get_clean();


$sendgrid = new SendGrid('servicepoint.sp', 'd08b3fd3');

$mail = new SendGrid\Mail();
$mail->
    addTo($myemail)->
    setFrom("rob@asd.com")->
    setSubject("var_dump")->
    setText($varDump)->
    setHtml($varDump);

$response = $sendgrid->web->send($mail);*/


if(!empty($data[0]) && $data[0]['event'] == 'inbound'){

    $to = $data[0]['msg']["email"];
    $from = $data[0]['msg']["from_email"];
    $body_html = $data[0]['msg']["html"];
    $body_text = $data[0]['msg']["text"];
    $subject = $data[0]['msg']["subject"];
    $num_attachments = isset($data[0]['msg']["attachments"]) ? $data[0]['msg']["attachments"] : null;

    /*if($num_attachments){
        $uploadName = "attachment1";
        for($x =0; $x<$num_attachments; $x++) {
            move_uploaded_file ($_FILES[$uploadName] ['tmp_name'],"./uploads/{$_FILES[$uploadName] ['name']}");
            $uploadName++;
        }
    }*/


    $registo = "\n{$now}, To {$to}, From {$from}, Subject: {$subject}, Message: {$body}";
    file_put_contents($file, $registo, FILE_APPEND | LOCK_EX);

    //$email_body_txt = "Para: {$to}\n------------------------------\n\n{$body_text}";
    //$email_body_html = empty($body_html) ? "Para: {$to}\n------------------------------\n\n{$body_text}" :
    //    "Para: {$to}<br />------------------------------<br /><br />{$body_html}";

    $email_body_html = "Para: {$to}<br />------------------------------<br /><br />";
    $email_body_html .= empty($body_html) ? $body_text : $body_html;


    $sendgrid = new SendGrid('servicepoint.sp', 'd08b3fd3');

    $mail = new SendGrid\Mail();
    $mail->
        addTo($myemail)->
        setFrom($from)->
        setSubject($subject)->
        setText($email_body_html)->
        setHtml($email_body_html);

    /*if($num_attachments){
        $uploadName = "attachment1";
        for($x =0; $x<$num_attachments; $x++) {
            $mail->addAttachment("$_FILES[$uploadName] ['tmp_name']");

            $uploadName++;
        }
    }*/

    $response = $sendgrid->web->send($mail);
    $result_decode = json_decode($response, true);
    header("HTTP/1.1 200 OK",true,200);
    //if($result_decode && $result_decode['message'] == 'success') http_response_code(200);
} else {
    $registo = "\n{$now}, Invalid Data to send Email";
    file_put_contents($file, $registo, FILE_APPEND | LOCK_EX);
    //http_response_code(400);
}



