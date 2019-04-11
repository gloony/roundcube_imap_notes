var notes = {
  favico: null, notification: null,
  nameurl: '',
  iswater: true,
  id: null,
  get: function(id, subject){
    notes.id = id;
    $('#messagecontframe').attr('src', './?_task=notes&_action=getNote&id=' + id);
    $('tr.message.selected').removeClass('selected');
    $('tr.message.focused').removeClass('focused');
    $('#trsHL' + id).addClass('selected');
    $('#trsHL' + id).addClass('focused');
    if(subject!==undefined&&subject!==null) document.title = 'Notes :: ' + subject;
    else document.title = 'Notes';
  },
  save: function(body){
    // var body = $('#messagecontframe').contents().find('textarea').html();
    if(body===undefined||body===null||body==='') return;
    var rmid = rcmsg.render(rcmail.gettext('saving', 'imap_notes'), 'loading');
    $.post({ url: './?_task=notes&_action=editNote' }, { id: notes.id, body: body })
      .done(function(json){
        rcmsg.remove(rmid);
        notes.id = 1;
        notes.list.load();
    });
  },
  delete: function(){
    if(notes.id===null) return;
    var rmid = rcmsg.render(rcmail.gettext('deleting', 'imap_notes'), 'loading');
    $.post({ url: './?_task=notes&_action=deleteNote' }, { id: notes.id })
      .done(function(json){
        rcmsg.remove(rmid);
        notes.list.load();
        notes.watermark();
    });
  },
  download: function(){
    if(notes.id===null) return;
    window.open('./?_task=notes&_action=downloadNote&id=' + notes.id);
  },
  scrollToElement: function(element, container){
    if(element===undefined || element===null) return;
    if(element.offsetTop < container.scrollTop){
      container.scrollTop = element.offsetTop;
    }else{
      var offsetBottom = element.offsetTop + element.offsetHeight;
      var scrollBottom = container.scrollTop + container.offsetHeight;
      if(offsetBottom > scrollBottom){
        container.scrollTop = offsetBottom - container.offsetHeight;
      }
    }
  },
  watermark: function(){
    if(!notes.iswater){
      notes.id = null;
      rcmail.enable_command('nextarticle', false);
      rcmail.enable_command('previousarticle', false);
      rcmail.enable_command('open', false);
      rcmail.enable_command('forward', false);
      notes.iswater = true;
      $('#messagecontframe').attr('src', './plugins/imap_notes/skins/elastic/templates/watermark.html');
    }
  }
};