<?php

namespace MoodleImporter;

require_once dirname(__FILE__) . '/../../../application/models/TrueFalseItem.php';
include_once dirname(__FILE__) . '/../../../application/models/XMLUtilities.php';

/**
 * Test class for TrueFalseItem.
 * Generated by PHPUnit on 2012-05-19 at 10:25:56.
 */
class TrueFalseItemTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers MoodleImporter\TrueFalseItem::ToXMLElement
     */
    public function testToXMLElementTrue() {
       $trueFalseItem = new TrueFalseItem;
       $trueFalseItem->Name = "TF 001 - What is";
       $trueFalseItem->PointValue = 2;
       $trueFalseItem->Text = 'What is';
       $trueFalseItem->CorrectAnswer = true;
       
       $expected = <<<'ESSAY_XML'
       <question type="truefalse">
        <name>
         <text><![CDATA[TF 001 - What is]]></text>
        </name> 
        <questiontext format="html">
         <text>What is</text>
        </questiontext>
        <defaultgrade>
            2
        </defaultgrade>
        <answer fraction="100">
            <text>true</text>
        </answer>
        <answer fraction="0">
            <text>false</text>
        </answer>
       </question>
ESSAY_XML;
       $expected = new \SimpleXMLElement($expected);
       $this->assertTrue(xml_is_equal($expected, $trueFalseItem->ToXMLElement(),false));  
               
    }
    
    /**
     * @covers MoodleImporter\TrueFalseItem::ToXMLElement 
     */
    public function testToXMLElementFalse()
    {
        $trueFalseItem = new TrueFalseItem;
        $trueFalseItem->Name = "TF 001 - What is";
        $trueFalseItem->PointValue = 2;
        $trueFalseItem->Text = 'What is';
        $trueFalseItem->CorrectAnswer = false;
       
        $expected = <<<'ESSAY_XML'
        <question type="truefalse">
        <name>
            <text><![CDATA[TF 001 - What is]]></text>
        </name> 
        <questiontext format="html">
            <text>What is</text>
        </questiontext>
        <defaultgrade>
            2
        </defaultgrade>
        <answer fraction="0">
            <text>true</text>
        </answer>
        <answer fraction="100">
            <text>false</text>
        </answer>
        </question>
ESSAY_XML;
        $expected = new \SimpleXMLElement($expected);
        $this->assertTrue(xml_is_equal($expected, $trueFalseItem->ToXMLElement(),false));  
    }

}

?>
