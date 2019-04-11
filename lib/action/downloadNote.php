<?php
	if(!isset($_GET['id'])) exit;
	include('.imap.php');
	$mid = $_GET['id'];

	$header = imap_headerinfo($mbox, $mid);
	$subject = $header->Subject;

	$body = imap_body($mbox, $mid);
	$body = quoted_printable_decode($body);
	$body = html_entity_decode($body);
	$pos = strpos($body, '</div>');
	if(substr($body, $pos, strlen('</div><div>'))!='</div><div>'&&substr($body, $pos, strlen('</div><div><br'))=='</div><div><br') $body = substr($body, 0, $pos)."\n".substr($body, $pos);
	$body = str_replace('<div><br></div>', "\n", $body);
	$body = str_replace('<br', "\n<br", $body);
	$body = str_replace('<div>', "\n<div>", $body);
	$body = str_replace('</p>', "</p>\n", $body);
	$body = str_replace("\r\n", "\n", $body);
	$body = strip_tags($body);
	while(substr($body, strlen($body) - strlen("\n"))=="\n") $body = substr($body, 0, strlen($body) - strlen("\n"));
	while(substr($body, 0, strlen("\n"))=="\n") $body = substr($body, strlen("\n"));

	$body = str_replace("\n", "\r\n", $body);

	header('Content-Description: File Transfer');
	header('Content-Type: text/plain');
	header('Content-Disposition: attachment;filename="'.$subject.'.txt"');

	echo $body;

	exit;