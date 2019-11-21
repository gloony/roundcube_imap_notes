<?php
	if(!isset($_GET['id'])) exit;
	include('.imap.php');
	$mid = $_GET['id'];

	if($mid!=-1){
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
	}else $body = '';
?><!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php // echo basename($cFile); ?></title>
		<script src="program/js/jquery.min.js?s=1535544655" type="text/javascript"></script>
		<script type="text/javascript" src="plugins/imap_notes/lib/codemirror/codemirror.min.js"></script>
		<link href="plugins/imap_notes/lib/codemirror/codemirror.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<textarea id="notepadarea" class="CodeMirror"><?php $hsc = htmlspecialchars($body); if($hsc!=""){ echo $hsc; }else{ echo $body; } ?></textarea>
		<span class="notepadIedit"></span><span class="notepadImacro"></span><span class="notepadIclipboard"></span>
		<script>
			var editor = CodeMirror.fromTextArea(document.getElementById('notepadarea'), {
				autoCloseBrackets: true,
				autoCloseTags: true,
				autofocus: true,
				electricChars: true,
				foldGutter: true,
				fullScreen: true,
				gutters: ["CodeMirror-lint-markers", "CodeMirror-linenumbers", "CodeMirror-foldgutter"],
				highlightSelectionMatches: {showToken: /\w/, annotateScrollbar: true},
				iframeClass: 'CodeMirror',
				indentUnit: 4,
				indentWithTabs: true,
				lineNumbers: true,
				lint: false,
				matchBrackets: true,
				matchTags: true,
				// scrollbarStyle: "overlay",
				showTrailingSpace: true,
				smartIndent: true,
				styleActiveLine: true,
				theme: 'github-light',
				keyMap: "sublime",
				mode: 'text',
				extraKeys: {
				  "Esc": function(cm){
					if(cm.somethingSelected()) cm.setCursor(cm.getCursor(), 0, {scroll: false});
				  },
				  "Tab": function(cm) {
					if(cm.somethingSelected()){ cm.execCommand("indentMore"); }
					else{ cm.execCommand("insertTab"); }
				  },
				  // "Alt-Up": function(cm){ notepad.selections.increment(cm, true); },
				  // "Alt-Down": function(cm){ notepad.selections.increment(cm, false); },
				  // "Alt-PageUp": function(cm){ top.explorer.taskbar.previous(); },
				  // "Alt-PageDown": function(cm){ top.explorer.taskbar.next(); },
				  // "Alt-S": function(cm){ notepad.selections.sort(cm); },
				  "Ctrl-Space": "autocomplete",
				  // "Ctrl-Up": function(cm){ notepad.selections.duplicateCursor(cm, true); },
				  // "Ctrl-Down": function(cm){ notepad.selections.duplicateCursor(cm, false); },
				  "Ctrl-F": function(cm){ cm.execCommand("findPersistent"); },
				  "Ctrl-G": function(cm){ cm.execCommand("jumpToLine"); },
				  "Ctrl-I": function(cm){ cm.execCommand("unfoldAll"); },
				  "Ctrl-K": "indentAuto",
				  // "Ctrl-P": function(cm){ notepad.macro.toggle(cm); },
				  "Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); },
				  // "Ctrl-R": function(cm){
					// notepad.forceReload = true;
					// notepad.reload();
				  // },
				  "Ctrl-S": function(cm){ top.notes.save(editor.getValue()); },
				  // "Ctrl-U": function(cm){ notepad.selections.changeCase(cm, false); },
				  // "Ctrl-W": function(cm){ notepad.close(cm); },
				  // "Shift-Alt-Up": function(cm){ notepad.selections.increment(cm, true, true); },
				  // "Shift-Alt-Down": function(cm){ notepad.selections.increment(cm, false, true); },
				  // "Shift-Ctrl-K": function(cm){ notepad.selections.indent(cm); },
				  "Shift-Ctrl-O": function(cm){ window.open('./?_task=notes&_action=getSource&id=<?php echo $mid; ?>'); },
				  // "Shift-Ctrl-P": function(cm){ notepad.macro.exec(cm); },
				  // "Shift-Ctrl-S": function(cm){ notepad.saveAs(cm); },
				  // "Shift-Ctrl-U": function(cm){ notepad.selections.changeCase(cm, true); },
				  // "Shift-Ctrl-V": function(cm){ notepad.clipboard.listening(cm); },
				  "Shift-Ctrl-Y": function(cm){ cm.execCommand("foldAll"); },
				  "Shift-Tab": "indentLess",
				  fallthrough: ["default"]
				}
			});
			editor.on('change', function(){ editor.save(); });
		</script>
	</body>
</html><?php
	imap_close($mbox);
	exit;