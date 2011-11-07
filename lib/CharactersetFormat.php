<?php

require_once 'Format.php';

class CharactersetFormat extends Format {

  protected static $from = array('characterset'), $label = 'characterset';

  public static function fromString ($string, $set) {
    $data = icovnv($set, 'UTF-8', $string);
    return $data === false ? false : new CharactersetFormat($data);
  }

  public function toString ($set = 'UTF-8') {
    return serialize($this->data);
  }

}
