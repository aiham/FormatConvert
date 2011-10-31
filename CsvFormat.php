<?php

require_once 'Format.php';

class CsvFormat extends Format {

  protected static $from = array('xml', 'json', 'serialize'), $label = 'csv';

  public static $quote = '"', $field_separator = ',', $row_separator = "\n";

  public static function fromString ($string, $use_headers = false) {

    // Convert all \r\n and \r to \n for consistency
    $data = str_replace("\r", "\n", str_replace("\r\n", "\n", $string));
    
    $quote = static::$quote;
    $field_separator = static::$field_separator;
    $row_separator = static::$row_separator;
    $get_headers = $use_headers;

    $headers = array();
    $row = array();
    $rows = array();
    $field = '';
    $column = 0;
    
    try {

      for ($i = 0, $l = mb_strlen($data), $k = $l - 1; $i < $l; $i++) {
      
        $c = $data[$i];
      
        if ($c === $quote) {
      
          if ($field !== '') {
            // Double quote in unquoted field
            throw new Exception();
          }
          
          $j = $i + 1;
      
          while (true) {
            $j = strpos($data, $quote, $j);

            if ($j === false) {
              // Missing send double quote of a pair
              throw new Exception();
            }
      
            if ($j < $k) {
              // If there is a character after
              $next = $data[$j + 1];

              if ($next === $quote) {
                // Escaped double quote
                $j += 2;
                continue;
              } else if (
                $next !== $field_separator &&
                $next !== $row_separator
              ) {
                // Invalid character after closing double quote
                throw new Exception();
              }
            }

            break;
          }
      
          $field = mb_substr($data, $i + 1, $j - $i - 1);
          $field = str_replace('""', '"', $field);

          $row[$use_headers && !$get_headers &&
            array_key_exists($column, $headers) ?
              $headers[$column] : $column] = $field;

          $field = '';
          $column++;
      
          $i = $j;

          if ($i === $k) {
            array_push($rows, $row);
          } else if ($data[$i + 1] === $field_separator) {
            $i++;
          }
      
        } else if ($c === $field_separator) {
      
          $row[$use_headers && !$get_headers &&
            array_key_exists($column, $headers) ?
              $headers[$column] : $column] = $field;

          $field = '';
          $column++;

          if ($i === $k) {
            $row[$use_headers && !$get_headers &&
              array_key_exists($column, $headers) ?
                $headers[$column] : $column] = $field;

            if (!$get_headers) {
              array_push($rows, $row);
            }
          }
      
        } else if ($c === $row_separator) {

          if (
            $field !== '' ||
            ($i > 0 && $data[$i - 1] === $field_separator)
          ) {
            $row[$use_headers && !$get_headers &&
              array_key_exists($column, $headers) ?
                $headers[$column] : $column] = $field;

            $field = '';
            $column++;
          }
      
          if (count($row) > 0) {
            if ($get_headers) {
              $headers = $row;
              $get_headers = false;
            } else {
              array_push($rows, $row);
            }
            $row = array();
            $column = 0;
          }
      
        } else {
      
          $field .= $c;

          if ($i === $k) {
            $row[$use_headers && !$get_headers &&
              array_key_exists($column, $headers) ?
                $headers[$column] : $column] = $field;

            if (!$get_headers) {
              array_push($rows, $row);
            }
          }
      
        }
      
      }

    } catch (Exception $e) {
      $rows = null;
    }

    return is_null($rows) ? false : new CsvFormat($rows);

  }

  public function toString () {

    $headers = array();

    foreach ($this->data as $row) {
      $headers = array_unique(array_merge($headers, array_keys($row)));
    }

    $headers = array_values($headers);

    $formatted_rows = array();

    foreach ($this->data as $row) {
      $ordered = array();
      foreach ($headers as $header) {
        $value = '"' . str_replace('"', '""', $row[$header]) . '"';
        array_push($ordered, $value);
      }
      array_push($formatted_rows, implode(',', $ordered));
    }

    unset($headers, $row, $ordered, $header, $value);

    return implode("\n", $formatted_rows);

  }

}
