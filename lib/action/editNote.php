<?php
	if(!isset($_POST['body'])) exit;
	include('.imap.php');

	$body = $_POST['body'];
	$body = str_replace("\r\n", "\n", $body);
	$bodys = explode("\n", $body);
	$body = quoted_printable_decode($body);
	$body = ''; $subject = '';
	foreach($bodys as $el){
		$el = str_replace("\n", '', $el);
		if($subject=='') $subject = $el;
		if($el=='') $el = '<br>';
		$body .= '<div>'.$el.'</div>';
	}

	if(isset($_POST['id'])){
		if($_POST['id']!=-1){
			imap_delete($mbox, $_POST['id']);
			imap_expunge($mbox);
		}
	}

	imap_append($mbox, $server
				, "Content-Type: text/html;\r\n"
				. "\tcharset=utf-8\r\n"
				. "Content-Transfer-Encoding: 7bit\r\n"
				. "From: ".strtoupper(substr($user, 0, 1)).substr($user, 1, strpos($user, '@') - 1)." <".$user.">\r\n"
				. "X-Uniform-Type-Identifier: com.apple.mail-note\r\n"
				. "Mime-Version: 1.0\r\n"
				. "Date: ".date('D, d M Y H:i:s P')."\r\n"
				. "X-Mail-Created-Date: ".date('D, d M Y H:i:s P')."\r\n"
				. "Subject: ".$subject."\r\n"
				. "\r\n"
				. $body."\r\n"
				, "\\Seen"
	);

	imap_close($mbox);
	exit;