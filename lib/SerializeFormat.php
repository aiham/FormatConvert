<?php

require_once 'Format.php';

class SerializeFormat extends Format {

  protected static $from = array('xml', 'csv', 'json'), $label = 'serialize';

  public static function fromString ($string) {
    $data = unserialize($string);
    return $data === false ? false : new SerializeFormat($data);
  }

  public function toString () {
    return serialize($this->data);
  }

}
