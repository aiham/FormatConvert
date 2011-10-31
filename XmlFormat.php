<?php

require_once 'Format.php';

class XmlFormat extends Format {

  protected static $from = array('json', 'csv', 'serialize'), $label = 'xml';

  public static function fromString ($string) {
    libxml_use_internal_errors(true);
    $xml = new SimpleXMLElement($string);
    if (!$xml) {
      return false;
    }

    // TODO - create $data array from $xml object

    return new XmlFormat($data);
  }

  public function toString ($format = false) {
    $xml = new SimpleXmlElement('<root/>');
    if (is_array($this->data)) {
      $this->traverseElement($xml, $this->data);
    }
    $string = $xml->asXML();
    return $format ? static::format($string) : $string;
  }

  protected function traverseElement ($xml, $data) {
    foreach ($data as $key => $element) {
      if (is_int($key)) {
        $key = 'value' . $key;
      }
      if (is_array($element)) {
        $this->traverseElement($xml->addChild($key), $element);
      } else {
        $xml->addChild($key, $element);
      }
    }
  }

  protected static function format ($string) {
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($string);
    
    return $dom->saveXML();
  }

}
