<?php


function htmlMail($to,$subject,$body){ // sends an html email
    $headers='MIME-Version: 1.0'."\r\n";
    $headers.='Content-type: text/html; charset=iso-8859-1'."\r\n";
    $headers.='From: Surya <surya@gmail.com>'."\r\n";
    $message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"'."\r\n";
    $message.="\t".'"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\r\n";
    $message.='<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">'."\r\n";
    $message.='<head>'."\r\n";
    $message.="\t".'<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />'."\r\n";
    $message.="\t".'<meta http-equiv="Content-Language" content="en-us" />'."\r\n";
    $message.="\t".'<title>'.$subject.'</title>'."\r\n";
    $message.='</head>'."\r\n";
    $message.='<body>'."\r\n";
    $message.="\t".$body."\r\n";
    $message.='</body>'."\r\n";
    $message.='</html>';
    return mail($to,$subject,$message,$headers);
}