<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Phrase\Analyser\PhraseAnalyser;

class PhraseAnalyserTest extends TestCase
{

    /**
     * Test the final result after analyser.
     */
    public function testTraverseGraph()
    {
        $string_to_analyse = 'test';
        $phraseAnalyser = new PhraseAnalyser($string_to_analyse);
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

        // Should have 4 lines in the table.
        // 1 line for the header + 3 lines for the result.
        $rows = substr_count($prepared_table, '<tr>');
        $this->assertEquals(4, $rows);

        // Should not contain the string to analyse.
        $this->assertNotContains($string_to_analyse, $prepared_table);
    }

    /**
     * Should return null for invalid max distance.
     */
    public function testFindInvalidMaxDistance()
    {
        $string_to_analyse = 'tesla';
        $phraseAnalyser = new PhraseAnalyser($string_to_analyse);

        $this->assertNull($phraseAnalyser->findMaxDistanceBetweenCharacters('b'));
    }

    /**
     * Should return max distance.
     */
    public function testFindValidMaxDistance()
    {
        $string_to_analyse = 'test';
        $phraseAnalyser = new PhraseAnalyser($string_to_analyse);

        $this->assertEquals(3, $phraseAnalyser->findMaxDistanceBetweenCharacters('t'));
    }

    /**
     * Should return max distance equal 10, once 10 is longest allowed.
     */
    public function testFindLongestMaxDistance()
    {
        $string_to_analyse = 'football vs soccer';
        $phraseAnalyser = new PhraseAnalyser($string_to_analyse);

        $this->assertEquals(10, $phraseAnalyser->findMaxDistanceBetweenCharacters('o'));
    }

    /**
     * Should return none, once the char T is not appearing after any char.
     */
    public function testFindAfterCharShouldReturnNone()
    {
        $string_to_analyse = 'tesla';
        $phraseAnalyser = new PhraseAnalyser($string_to_analyse);

        $this->assertEquals('none', $phraseAnalyser->findAfterCharacters('t'));
    }

    /**
     * Should return char E, once the S appears after char E.
     */
    public function testFindAfterCharShouldReturnValue()
    {
        $string_to_analyse = 'tesla';
        $phraseAnalyser = new PhraseAnalyser($string_to_analyse);

        $this->assertEquals('e', $phraseAnalyser->findAfterCharacters('s'));
    }

    /**
     * Should return none, once the A is not appearing before any char.
     */
    public function testFindBeforeCharShouldReturnNone()
    {
        $string_to_analyse = 'tesla';
        $phraseAnalyser = new PhraseAnalyser($string_to_analyse);

        $this->assertEquals('none', $phraseAnalyser->findBeforeCharacters('a'));
    }

    /**
     * Should return char E, once the T appears before char E.
     */
    public function testFindBeforeCharShouldReturnValue()
    {
        $string_to_analyse = 'tesla';
        $phraseAnalyser = new PhraseAnalyser($string_to_analyse);

        $this->assertEquals('e', $phraseAnalyser->findBeforeCharacters('t'));
    }
}
