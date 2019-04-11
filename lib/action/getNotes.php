<?php
	include('.imap.php');
	$mids = imap_search($mbox, 'ALL');

	$empty = true;
	echo '<table id="messagelist" class="listing messagelist sortheader fixedheader focus" aria-labelledby="aria-label-messagelist" data-list="message_list" data-label-msg="'.rcube::Q($this->gettext('listempty')).'">';
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
		echo '  <tr id="trsHL'.$mid.'" class="message" onClick="notes.get('.$mid.', \''.$subject.'\'); return false;">
    <td class="selection">
      <input type="checkbox" tabindex="-1">
    </td>
    <td class="subject" tabindex="0">
      <span class="fromto skip-on-drag">
        <span class="adr">
          <span class="rcmContactAddress" title="'.$subject.'" return false;">'.$subject.'</span>
        </span>
      </span>
      <span class="date skip-on-drag" title="'.$date.'">'.$date.'</span>
      <span class="subject">
        <span id="wdNS.tree" class="msgicon status" return false;"></span>
        <a tabindex="-1" title="'.$description.'">
          <span>'.$description.'</span>
        </a>
      </span>
    </td>
  </tr>';
	}
	if($empty) echo '<div class="listing-info">'.rcube::Q($this->gettext('listempty')).'</div>';
	echo "\n".'</table>';

	imap_close($mbox);
	exit;