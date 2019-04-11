rcmail.addEventListener('init', function(evt){
  $('body').on('keydown', function(e){ if(notes.keyboard.onKeyDown(e)){ return true; }else{ e.preventDefault(); return false; } });
  // notes.categories.load();
  notes.list.load();

//   rcmail.register_command('checkmail', ttrss.refresh, true);
//   rcmail.register_command('firstpage', ttrss.headlines.page.first, false);
//   rcmail.register_command('nextpage', ttrss.headlines.page.next, false);
//   rcmail.register_command('previouspage', ttrss.headlines.page.previous, false);
//   rcmail.register_command('nextarticle', ttrss.article.next, false);
//   rcmail.register_command('previousarticle', ttrss.article.previous, false);
//   rcmail.register_command('open', ttrss.article.open, false);
//   rcmail.register_command('forward', ttrss.article.forward, false);

//   rcmail.register_command('feed_subscribe', ttrss.feed.subscription.add.show, false);
//   rcmail.register_command('feed_unsubscribe', null, false);

//   rcmail.register_command('select-all', ttrss.article.select.all, false);
//   rcmail.register_command('select-unread', ttrss.article.select.unread, false);
//   rcmail.register_command('select-flagged', ttrss.article.select.flagged, false);
//   rcmail.register_command('select-invert', ttrss.article.select.invert, false);
//   rcmail.register_command('select-none', ttrss.article.select.none, false);
});