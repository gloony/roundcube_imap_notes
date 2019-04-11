<?php
	include('.imap.php');
	$mids = imap_search($mbox, 'ALL');

	$empty = true;
?><style>
@import url(https://fonts.googleapis.com/css?family=Gloria+Hallelujah);
* { box-sizing:border-box; }
body { background:url(https://subtlepatterns.com/patterns/little_pluses.png) #cacaca; margin:30px; }
#create, textarea  { 
  float:left; 
  padding:25px 25px 40px;
  margin:0 20px 20px 0;
  width:250px;
  height:250px; 
}
#create {
  user-select:none;
  padding:20px; 
  border-radius:20px;
  text-align:center; 
  border:15px solid rgba(0,0,0,0.1); 
  cursor:pointer;
  color:rgba(0,0,0,0.1);
  font:220px "Helvetica", sans-serif;
  line-height:185px;
}
#create:hover { border-color:rgba(0,0,0,0.2); color:rgba(0,0,0,0.2); }
textarea {
  font:20px 'Gloria Hallelujah', cursive; 
  line-height:1.5;
  border:0;
  border-radius:3px;
  background: linear-gradient(#F9EFAF, #F7E98D);
  box-shadow:0 4px 6px rgba(0,0,0,0.1);
/*   overflow:hidden; */
  transition:box-shadow 0.5s ease;
  font-smoothing:subpixel-antialiased;
/*   max-width:520px; */
/*   max-height:250px; */
}
textarea:hover { box-shadow:0 5px 8px rgba(0,0,0,0.15); }
textarea:focus { box-shadow:0 5px 12px rgba(0,0,0,0.2); outline:none; }
</style>
<script>
$("#create").click(function() {
  $(this).before("<textarea></textarea>");
});
</script><?php
	$mids = array_reverse($mids);
	foreach($mids as $mid){
		$header = imap_headerinfo($mbox, $mid);
		$subject = $header->Subject;
		$date = date('d.m.y H:i:s', strtotime($header->MailDate));
		$description = substr(strip_tags(quoted_printable_decode(imap_body($mbox, $mid))), strlen($header->Subject), 64);
		$description = str_replace("\r\n", '', $description);
		$description = str_replace("\n", '', $description);
		if($empty) $empty = false;
		if($cat<>-1){
			$prop = json_decode($item['properties'], true);
			if($prop['category']!=$cat) continue;
		}
		$body = imap_body($mbox, $mid);
		$body = quoted_printable_decode($body);
		$body = html_entity_decode($body);
		$pos = strpos($body, '</div>');
		if(substr($body, $pos, strlen('</div><div>'))!='</div><div>'||substr($body, $pos, strlen('</div><div><br'))=='</div><div><br') $body = substr($body, 0, $pos)."\n".substr($body, $pos);
		$body = str_replace('<div><br></div>', "\n", $body);
		$body = str_replace('<br', "\n<br", $body);
		$body = str_replace('<div>', "\n<div>", $body);
		$body = str_replace('</p>', "</p>\n", $body);
		$body = str_replace("\r\n", "\n", $body);
		$body = strip_tags($body);
		while(substr($body, strlen($body) - strlen("\n"))=="\n") $body = substr($body, 0, strlen($body) - strlen("\n"));
		while(substr($body, 0, strlen("\n"))=="\n") $body = substr($body, strlen("\n"));
		echo '<textarea>'.$body.'</textarea>';
	}
	echo '<div id="create">+</div>';

	imap_close($mbox);
	exit;