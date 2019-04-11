notes.categories = {
  load: function(){
    var rmid = rcmsg.render(rcmail.gettext('loadcategory', 'imap_notes'), 'loading');
    $('#mailboxlist').load('./?_task=notes&_action=getCategories&mode=true', function(){
      rcmsg.remove(rmid);
      notes.categories.loadfunc();
    });
  },
  loadfunc: function(){
    $('#mailboxlist.treelist li a').each(function(){
      var id = $(this).parent().attr('id');
      var color = $(this).parent().data('color');
      if(color!='') document.styleSheets[0].addRule('#' + id + ' a:before', 'color: #' + color + ';');
    });
  }
};