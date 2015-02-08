<?php
include 'libs/SendGrid_loader.php';

$errors = '';
$myemail = 'servicepoint.sp@gmail.com';

if(empty($_POST['name'])  || empty($_POST['email']))  /*|| empty($_POST['type'])  || empty($_POST['estab_name'])  || empty($_POST['address']))*/
{
    $errors .= "\n Error: all fields are required";
    echo "Erro, por favor actualize a página e tente novamente.";
    return;
}

$name = $_POST['name'];
$email_address = $_POST['email'];
$message = $_POST['message'];
/*$type = $_POST['type'];
$estab_name = $_POST['estab_name'];
$address = $_POST['address'];*/

if (!preg_match(
"/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", 
$email_address))
{
    $errors .= "\n Error: Invalid email address";
    echo "Erro, por favor actualize a página e tente novamente.";
    return;
}

if( empty($errors))
{
	$to = $myemail; 
	$email_subject = "NOVO REGISTO: $name";
	$email_body = "Email automático de registo do ServicePoint<br /><br /> Name: {$name} <br /> Email: {$email_address} <br /> Message: {$message} <br /><br /><br /> Toca a inserir à mão na base de dados!";  /*Tipo de estabelecimento: {$type} <br /> Nome do Estabelecimento: {$estab_name} <br /> Endereço: {$address}*/

    $sendgrid = new SendGrid('servicepoint.sp', 'd08b3fd3');

    $mail = new SendGrid\Mail();
    $mail->
        addTo($myemail)->
        setFrom($email_address)->
        setSubject($email_subject)->
        setText($email_body)
        ->setHtml($email_body);

    $response = $sendgrid->web->send($mail);
    $result_decode = json_decode($response, true);

    if($mail) echo "success";
}
