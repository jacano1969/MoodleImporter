<?php

namespace MoodleImporter;
if (!defined('APPPATH'))
{
    define('APPPATH', dirname(__FILE__) . '/../../../application');
}

require_once APPPATH . '/models/Quiz.php';
require_once 'bb6xml.php';

/**
 * Test class for MatchingItem.
 * Generated by PHPUnit on 2012-05-19 at 11:48:59.
 */
class MatchingItemTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers MoodleImporter\MatchingItem::ToXMLElement
     */
    public function testToXMLElement() {
        $matchingItem = new MatchingItem;
        $matchingItem->Title = "What is";
        $matchingItem->PointValue = 2;
        $matchingItem->Text = 'What is';
        $op1 = new MatchingOption('Option 1', 'Definition 1');
        $op2 = new MatchingOption('Option 2', 'Definition 2');
        $op3 = new MatchingOption('Option 3', 'Definition 3');
        $matchingItem->Options[] = $op1;
        $matchingItem->Options[] = $op2;
        $matchingItem->Options[] = $op3;
        $matchingItem->CorrectFeedback = "Your answer is correct!";
        $matchingItem->IncorrectFeedback = "Your answer is INCORRECT!";

        $expected = <<<'MATCHING_XML'
        <question type="matching">
            <name>
                <text>MT 001 - What is</text>
            </name> 
            <questiontext format="html">
                <text>What is</text>
            </questiontext>
            <defaultgrade>
                2
            </defaultgrade>
            <correctfeedback><![CDATA[Your answer is correct!]]></correctfeedback>
            <incorrectfeedback><![CDATA[Your answer is INCORRECT!]]></incorrectfeedback>
            <subquestion>
                <text>
                    <![CDATA[Option 1]]>
                </text>
                <answer>
                    <![CDATA[Definition 1]]>
                </answer>
            </subquestion>
            <subquestion>
                <text>
                    <![CDATA[Option 2]]>
                </text>
                <answer>
                    <![CDATA[Definition 2]]>
                </answer>
            </subquestion>
            <subquestion>
                <text>
                    <![CDATA[Option 3]]>
                </text>
                <answer>
                    <![CDATA[Definition 3]]>
                </answer>
            </subquestion>
        </question>
MATCHING_XML;
        $expected = new \SimpleXMLElement($expected);
        $this->assertTrue(xml_is_equal($expected, $matchingItem->ToXMLElement(),false)); 
    }
    
    public function testToHTML() {
        $matchingItem = new MatchingItem;
        $matchingItem->Title = "What is";
        $matchingItem->PointValue = 2;
        $matchingItem->Text = 'What is';
        $op1 = new MatchingOption('Option 1', 'Definition 1');
        $op2 = new MatchingOption('Option 2', 'Definition 2');
        $op3 = new MatchingOption('Option 3', 'Definition 3');
        $matchingItem->Options[] = $op1;
        $matchingItem->Options[] = $op2;
        $matchingItem->Options[] = $op3;
       
        $expected = <<<'MATCHING_HTML'
        <p>Name: MT 001 - What is</p>
        <p>Question Text: What is</p>
        <dl>
            <dt>Option 1</dt><dd>Definition 1</dd>
            <dt>Option 2</dt><dd>Definition 2</dd>
            <dt>Option 3</dt><dd>Definition 3</dd>
        </dl>
MATCHING_HTML;
        
        $this->assertTrue(html_is_equal($expected, $matchingItem->ToHTML())); 
    }
    
    public function testFromBB6()
    {
        //$itemData = \BB6XML::GetBB6MTItemData();
        // First get rid of all unneeded whitespace not inside any tags
        $quizString = preg_replace('~\s*(<([^>]*)>[^<]*</\2>|<[^>]*>)\s*~','$1',\BB6XML::GetBB6MTItemData());
        $itemData = str_replace('\r\n', "", $quizString);
        $itemElement = new \SimpleXMLElement($itemData);
        $mtItem = new MatchingItem();
        $mtItem->ImportBB6XML($itemElement, "001");
        $this->assertEquals('MT 001 - This is the question title', $mtItem->GetName());
        $this->assertEquals('001', $mtItem->ID);
        $this->assertEquals('This is the question text.', $mtItem->Text);
        $this->assertEquals(4, count($mtItem->Options));
        $this->assertEquals("  Bad JOB", $mtItem->IncorrectFeedback);
        $this->assertEquals("  Good JOB", $mtItem->CorrectFeedback);
    }

}

?>
