<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Roberto
 * Date: 31-07-2013
 * Time: 11:43
 * To change this template use File | Settings | File Templates.
 */
$port = 9999;
$redirect = "http://".$_SERVER['HTTP_HOST'].":".$port;
$location = $redirect.$_SERVER['REQUEST_URI'];
header("Location: $location"); /* Redirect browser */

/* Make sure that code below does not get executed when we redirect. */
exit;

