<?php
	if(!isset($_POST['id'])) exit;
	include('.imap.php');
	imap_delete($mbox, $_POST['id']);
	imap_expunge($mbox);
	imap_close($mbox);
	exit;