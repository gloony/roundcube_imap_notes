<?php
	if(!isset($_GET['id'])) exit;
	include('.imap.php');
	$mid = $_GET['id'];

	$body = imap_body($mbox, $mid);
	$body = quoted_printable_decode($body);
	$body = html_entity_decode($body);
	$body = str_replace('</div>', "</div>\n", $body);
	echo $body;

	imap_close($mbox);
	exit;