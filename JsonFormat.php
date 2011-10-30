<?php

require_once 'Format.php';

class JsonFormat extends Format {

  protected static $from = array('xml', 'csv'), $label = 'json';

  public static function fromString ($string) {
    $data = json_decode($string, true);
    return is_null($data) ? false : new JsonFormat($data);
  }

  public function toString () {
    return json_encode($this->data);
  }

}
