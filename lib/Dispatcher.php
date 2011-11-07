<?php

require_once dirname(__FILE__) . '/Template.php';

class Dispatcher {

  protected $template;

  public function __construct () {
    $this->template = new Template();
  }

  public function dispatch () {
    $this->setPath(dirname(__FILE__) . '/templates/index.php');
    $this->display();
  }

}
