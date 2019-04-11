<?php
class imap_notes extends rcube_plugin
{
  public $task = '.*';
  public $rc;
  public $rcmail;
  public $ui;

  private $pagesize = 50;
  private $autoread = false;
  private $showonlyunread = false;

  function init()
  {
    $this->rc = rcube::get_instance();
    $this->rcmail = rcmail::get_instance();
    $this->load_config();
    $this->add_texts('localization/');
    $this->register_task('notes');
    $this->add_hook('startup', array($this, 'startup'));
    $this->register_action('index', array($this, 'index'));
  }
  function startup()
  {
    $this->register_action('getNotes', array($this, 'loadAction'));
    $this->register_action('getNote', array($this, 'loadAction'));
    $this->register_action('getSource', array($this, 'loadAction'));
    $this->register_action('editNote', array($this, 'loadAction'));
    $this->register_action('downloadNote', array($this, 'loadAction'));
    $this->register_action('deleteNote', array($this, 'loadAction'));
    $this->register_action('alphaNotes', array($this, 'loadAction'));
    $this->register_action('betaNotes', array($this, 'loadAction'));
    if(!$this->rcmail->output->framed)
    {
      $this->add_button(array(
        'command'    => 'notes',
        'class'      => 'button-notes',
        'classsel'   => 'button-notes button-selected',
        'innerclass' => 'button-inner',
        'label'      => 'imap_notes.notes',
        'type'       => 'link',
      ), 'taskbar');
      $this->include_stylesheet($this->local_skin_path().'/css/taskmenu.css');
    }
  }

  function index()
  {
    if($this->rcmail->action == 'index')
    {
      $this->add_texts('localization/', true);
      $url = $this->rc->config->get('imap_notes_url');
      $url = str_replace('http://', '', $url);
      $url = str_replace('https://', '', $url);
      $url = substr($url, 0, strlen($url) - 1);
      $header_title = $this->rc->user->get_username();
      $this->rcmail->output->set_env('imap_notes_header_title', $header_title);
      $skin_path = $this->local_skin_path();
      $this->include_script($skin_path.'/js/locStore.js');
      $this->include_script($skin_path.'/js/init.js');
      $this->include_script($skin_path.'/js/rcmsg.js');
      $this->include_script($skin_path.'/js/notes/notes.js');
      $this->include_script($skin_path.'/js/notes/categories.js');
      $this->include_script($skin_path.'/js/notes/list.js');
      $this->include_script($skin_path.'/js/notes/keyboard.js');
      $this->include_stylesheet($skin_path."/css/notes.css");
      $this->rcmail->output->set_pagetitle($this->gettext('notes'));
      $this->rcmail->output->add_handlers(array('ttrsscontent' => array($this, 'content')));
      $this->rcmail->output->send('imap_notes.notes');
    }
  }
  function content($attrib)
  {
    return $this->rcmail->output->frame($attrib);
  }

  function loadAction()
  {
    require_once __DIR__ . '/lib/action/'.$this->rc->action.'.php';
  }
}