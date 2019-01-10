<?php

namespace Phrase\Analyser;

class PhraseAnalyser {
  private $string;
  private $string_in_array;
  private $array_values;

  public function __construct($string_value) {
    $this->setString($string_value);
    $this->setStringInArray();
    $this->setArrayValues();
  }

  /**
   * Set value for string.
   * 
   * @param string $value
   */
  private function setString($value) {
    $this->string = $value;
  }

  /**
   * Set value for string_in_array based on string property.
   */
  private function setStringInArray() {
    if (isset($this->string)) {
      $this->string_in_array = str_split($this->string);
    }
  }

  /**
   * Set value for array_values based on string_in_array property.
   */
  private function setArrayValues() {
    if (isset($this->string_in_array)) {
      $this->array_values = array_count_values($this->string_in_array);
    }
  }

  /**
   * Render the final result.
   */
  public function render() {
    printf('The string is: <strong>%s</strong><br><br>', $this->string);
    print $this->prepareHTMLTable();
    print '<br><br>Type another string, <a href="/">back</a>';
  }

  /**
   * Create the HTML table based on the initial values.
   * 
   * @return string
   */
  public function prepareHTMLTable() {
    $table = "
      <table border=true>
        <thead>
          <tr>
            <th>Character</th>
            <th>Times</th>
            <th>Sibling</th>
          </tr>
        </thead>
        <tbody>
    ";
  
    foreach ($this->array_values as $character => $quantity) {
      $table .= '
        <tr>
          <td>' . $character . '</td>
          <td>' . $quantity . '</td>
          <td>' . $this->renderSiblingCharacter($character, $quantity) . '</td>
        </tr>
      ';
    }
  
    $table .= '
        </tbody>
      </table>
    ';

    return $table;
  }

  /**
   * Create values for the third column for the table.
   * 
   * Find which character shows before the specified character.
   * Find which character shows after the specified character.
   * Count the distance between first and last duplicate words if necessary.
   * 
   * @return string
   */
  private function renderSiblingCharacter($character, $quantity) {
    $character_before = $this->findBeforeCharacters($character);
    $character_after = $this->findAfterCharacters($character);
    $max_distance = '';

    $column = '<strong>before:</strong> %s <strong>after:</strong> %s';
  
    if ($quantity > 1) {
      $max_distance = $this->findMaxDistanceBetweenCharacters($character);
      $column .= ' <strong>max-distance:</strong> %d char(s)';
    }
  
    return sprintf($column, $character_before, $character_after, $max_distance);
  }

  /**
   * Find which character shows before the specified character.
   * 
   * If don't find any character return "none", 
   * else return a string separated by comma with characters.
   * 
   * @return string
   */
  private function findBeforeCharacters($character) {
    $char_before = [];
    $total = count($this->string_in_array) - 1;

    for ($i = 0; $i <= $total; $i++) {
      if ($character === $this->string_in_array[$i] && ($i+1 <= $total)) {
        $char_before[] = $this->string_in_array[$i+1];
      }
    }

    if (empty($char_before)) {
      return "none";
    }

    return str_replace(" ", '"space"', implode($char_before, ','));
  }

  /**
   * Find which character shows after the specified character.
   * 
   * If don't find any character return "none",
   * else return a string separated by comma with characters.
   * 
   * @return string
   */
  private function findAfterCharacters($character) {
    $char_after = [];
    $total = count($this->string_in_array) - 1;

    for ($i = 0; $i <= $total; $i++) {
      if ($character === $this->string_in_array[$i] && ($i-1 >= 0)) {
        $char_after[] = $this->string_in_array[$i-1];
      }
    }

    if (empty($char_after)) {
      return "none";
    }

    return str_replace(" ", '"space"', implode($char_after, ','));
  }

  /**
   * Count the distance between first and last duplicate words.
   * 
   * Longest allowed distance is 10
   * 
   * @return int
   */
  private function findMaxDistanceBetweenCharacters($character) {
    $max_distance = 10;

    $first_position = array_search($character, $this->string_in_array);
    $last_postion = array_search($character, array_reverse($this->string_in_array, true));
    
    $distance = $last_postion - $first_position;
    $distance = ($distance > $max_distance) ? $max_distance : $distance;

    return $distance;
  }
}

if (isset($_POST["string"])) {
  $phraseAnalyser = new PhraseAnalyser($_POST["string"]);
  $phraseAnalyser->render();
}