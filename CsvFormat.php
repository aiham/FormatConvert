<?php

require_once 'Format.php';

class CsvFormat extends Format {

  protected static $from = array('xml', 'json'), $label = 'csv';

  public static function fromString ($string) {
  }

  public function toString () {
  }

}
