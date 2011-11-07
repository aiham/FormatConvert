<?php

define('LIB_DIR', dirname(__FILE__) . '/');
define('TEMPLATE_DIR', LIB_DIR . 'templates/');

require_once LIB_DIR . 'Template.php';

class Dispatcher {

  protected $template;

  public function __construct () {
  }

  public function dispatch () {
    $this->template = new Template();

    try {

      if (strtolower($_POST['REQUEST_METHOD']) === 'post') {

        $this->dispatch_convert();

      } else {

        $this->dispatch_index();

      }

    } catch (Exception $e) {

      $this->dispatch_error($e->getMessage());

    }

    $this->template->display();
  }

  protected function dispatch_index () {
    $this->template->setPath(TEMPLATE_DIR . 'index.php');
  }

  protected function dispatch_convert () {
    $this->template->setPath(TEMPLATE_DIR . 'convert.php');
  }

  protected function dispatch_error ($message) {
    $this->template->setPath(TEMPLATE_DIR . 'error.php');
    $this->template->assign('message', $message);
  }

}
