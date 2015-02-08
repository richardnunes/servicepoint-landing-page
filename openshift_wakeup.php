<?php
include 'libs/SendGrid_loader.php';
	
	//$url = "http://www.spoint.pt/?p=52af5309f359276045000005"; // Link valido
	$url[0] = "http://www.spoint.pt/";
    $url[1] = "http://spoint.pt/";
    $url[2] = "http://node-servicepointdev.rhcloud.com/";
    $valid = true;

    foreach($url as $i=>$u){
        $data[$i] = @file_get_contents($u);
        $valid = $valid && !$data[$i];
    }

	if ($valid) {
		  $error = error_get_last();
		  $msg = "HTTP request failed. Error was: " . $error['message'];
		  $subject = "Openshift WakeUp Service - Warning!!";
	} else {
		  $msg = "Everything went better than expected";
		  $subject = "Openshift WakeUp Service - Success :)";
	}

    $headers = "From: servicepoint.sp@gmail.com\n";
    $headers .= "Reply-To: suporte@servicepoint.pt";

    mail("suporte@servicepoint.pt",$subject,$msg,$headers);
	
	/*$sendgrid = new SendGrid('servicepoint.sp', 'd08b3fd3');

    $rabico = "SendGrid\Mail";
    $mail = new $rabico();
    $mail->
        addTo('servicepoint.sp@gmail.com')->
        setFrom('suporte@servicepoint.pt')->
        setSubject($subject)->
        setText($msg)
        ->setHtml($msg);

    $response = $sendgrid->web->send($mail);*/

    echo $msg;
    

?>
