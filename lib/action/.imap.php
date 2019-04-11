<?php
	$user		= $_SESSION['username'];
	$pass		= $this->rcmail->decrypt($_SESSION['password']);
	$server		= '{'.$_SESSION['storage_host'].':'.$_SESSION['storage_port'].'/imap/'.$_SESSION['storage_ssl'].'}INBOX.Notes';
	$mbox		= imap_open($server, $user, $pass);