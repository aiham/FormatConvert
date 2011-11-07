<?php

require_once 'Format.php';

class CharactersetFormat extends Format {

  protected static $from = array('characterset'), $label = 'characterset';

  public static function fromString ($string, $set = 'UTF-8') {
    if ($set !== 'UTF-8') {
      $string = iconv($set, 'UTF-8', $string);
    }
    return $string === false ? false : new CharactersetFormat($string);
  }

  public function toString ($set = 'UTF-8') {
    return $set !== 'UTF-8' ? iconv('UTF-8', $set, $this->data) : $this->data;
  }

}
