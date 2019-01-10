<?php

use PHPUnit\Framework\TestCase;
use Phrase\Analyser\PhraseAnalyser;

class PhraseAnalyserTest extends TestCase {

  public function testTraverseGraph() {
    $phraseAnalyser = new PhraseAnalyser('test');
    $prepared_table = $phraseAnalyser->prepareHTMLTable();
    
    // Contains max-distance equal 3.
    $this->assertContains(
      '<strong>before:</strong> e <strong>after:</strong> s <strong>max-distance:</strong> 3 char(s)', 
      $prepared_table
    );

    // Contains a header.
    $this->assertContains(
      '<thead>', 
      $prepared_table
    );
   
    // Should have 4 lines the table.
    // 1 line for the header + 3 lines for the result.
    $rows = substr_count($prepared_table, '<tr>');
    $this->assertEquals(4, $rows);

    // Should not contain the string test.
    $this->assertNotContains('test', $prepared_table);
  }
}