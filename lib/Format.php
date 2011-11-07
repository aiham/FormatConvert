<?php

abstract class Format {

  protected $data;
  protected static $from = array(), $label = '';

  public function __construct ($data = null) {
    $this->data = $data;
  }

  public function getData () {
    return $this->data;
  }

  public static function getLabel () {
    return static::$label;
  }

  public static function canConvertFrom ($from) {
    return in_array($from, static::$from);
  }

  abstract public function toString ();
  abstract public static function fromString ($string);

  public function convert ($to) {
    $class = ucfirst(strtolower($to)) . 'Format';
    return $class::canConvertFrom(static::getLabel()) ?
      new $class($this->data) :
      false;
  }

}
