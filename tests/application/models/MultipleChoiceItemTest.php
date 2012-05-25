<?php

namespace MoodleImporter;
if (!defined('APPPATH'))
{
    define('APPPATH', dirname(__FILE__) . '/../../../application');
}

require_once APPPATH . '/models/Quiz.php';

/**
 * Test class for MultipleChoiceItem.
 * Generated by PHPUnit on 2012-05-20 at 14:33:56.
 */
class MultipleChoiceItemTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers MoodleImporter\MultipleChoiceItem::ApplyTBLTemplate 
     */
    public function testApplyTBLTemplate()
    {
        $mcItem = new MultipleChoiceItem;
        $mcItem->Name = "MC 001 - What is";
        $mcItem->PointValue = 2;
        $mcItem->ShuffleAnswers = true;
        $mcItem->Text = "What is the answer to this question?";
        $mcItem->SingleSelection = true;
        $mcItem->AnswerNumbering = "abc";
 
        $option1 = new MultipleChoiceOption;
        $option1->Text = "The correct answer";
        $option1->Value = 100;
        
        $option2 = new MultipleChoiceOption;
        $option2->Text = "A distractor";
        $option2->Value = 0;
        
        $option3 = new MultipleChoiceOption;
        $option3->Text = "Another distractor";
        $option3->Value = 0;

        $mcItem->Options = array($option1, $option2, $option3);
        
        $mcItem->ApplyTBLTemplate(true);
        
        $this->assertEquals(false, $mcItem->SingleSelection);
        $this->assertEquals(-50, $mcItem->Options[1]->Value);
        $this->assertEquals(-50, $mcItem->Options[2]->Value);
    }
    
     /**
     * @covers MoodleImporter\MultipleChoiceItem::ApplyTBLTemplate 
     */
    public function testApplyTBLTemplate5Items()
    {
        $mcItem = new MultipleChoiceItem;
        $mcItem->Name = "MC 001 - What is";
        $mcItem->PointValue = 2;
        $mcItem->ShuffleAnswers = true;
        $mcItem->Text = "What is the answer to this question?";
        $mcItem->SingleSelection = true;
        $mcItem->AnswerNumbering = "abc";
 
        $option1 = new MultipleChoiceOption;
        $option1->Text = "The correct answer";
        $option1->Value = 100;
        
        $option2 = new MultipleChoiceOption;
        $option2->Text = "A distractor";
        $option2->Value = 0;
        
        $option3 = new MultipleChoiceOption;
        $option3->Text = "Another distractor";
        $option3->Value = 0;
        
        $option4 = new MultipleChoiceOption;
        $option4->Text = "A distractor";
        $option4->Value = 0;
        
        $option5 = new MultipleChoiceOption;
        $option5->Text = "Another distractor";
        $option5->Value = 0;

        $mcItem->Options = array($option1, $option2, $option3, $option4, $option5);
        
        $mcItem->ApplyTBLTemplate(true);
        
        $this->assertEquals(false, $mcItem->SingleSelection);
        $this->assertEquals(-25, $mcItem->Options[1]->Value);
        $this->assertEquals(-25, $mcItem->Options[2]->Value);
        $this->assertEquals(-25, $mcItem->Options[3]->Value);
        $this->assertEquals(-25, $mcItem->Options[4]->Value);

    }
    
    
    /**
     * @covers MoodleImporter\MultipleChoiceItem::ApplyTBLTemplate 
     */
    public function testApplyTBLTemplate4Items()
    {
        $mcItem = new MultipleChoiceItem;
        $mcItem->Name = "MC 001 - What is";
        $mcItem->PointValue = 2;
        $mcItem->ShuffleAnswers = true;
        $mcItem->Text = "What is the answer to this question?";
        $mcItem->SingleSelection = true;
        $mcItem->AnswerNumbering = "abc";
 
        $option1 = new MultipleChoiceOption;
        $option1->Text = "Another distractor";
        $option1->Value = 0;
        
        $option2 = new MultipleChoiceOption;
        $option2->Text = "A distractor";
        $option2->Value = 0;
        
        $option3 = new MultipleChoiceOption;
        $option3->Text = "The correct answer";
        $option3->Value = 100;
        
        $option4 = new MultipleChoiceOption;
        $option4->Text = "A distractor";
        $option4->Value = 0;
        

        $mcItem->Options = array($option1, $option2, $option3, $option4);
        
        $mcItem->ApplyTBLTemplate(true);
        
        $this->assertEquals(false, $mcItem->SingleSelection);
        $this->assertEquals(-33.333333333333, $mcItem->Options[0]->Value);
        $this->assertEquals(-33.333333333333, $mcItem->Options[1]->Value);
        $this->assertEquals(-33.333333333333, $mcItem->Options[3]->Value);
    }
    
    
        /**
     * @covers MoodleImporter\MultipleChoiceItem::ApplyTBLTemplate 
     */
    public function testApplyTBLTemplateFalse()
    {
        $mcItem = new MultipleChoiceItem;
        $mcItem->Name = "MC 001 - What is";
        $mcItem->PointValue = 2;
        $mcItem->ShuffleAnswers = true;
        $mcItem->Text = "What is the answer to this question?";
        $mcItem->SingleSelection = FALSE;
        $mcItem->AnswerNumbering = "abc";
 
        $option1 = new MultipleChoiceOption;
        $option1->Text = "Another distractor";
        $option1->Value = -33.333333333333;
        
        $option2 = new MultipleChoiceOption;
        $option2->Text = "A distractor";
        $option2->Value = -33.333333333333;
        
        $option3 = new MultipleChoiceOption;
        $option3->Text = "The correct answer";
        $option3->Value = 100;
        
        $option4 = new MultipleChoiceOption;
        $option4->Text = "A distractor";
        $option4->Value = -33.333333333333;
        

        $mcItem->Options = array($option1, $option2, $option3, $option4);
        
        $mcItem->ApplyTBLTemplate(false);
        
        $this->assertEquals(true, $mcItem->SingleSelection);
        $this->assertEquals(0, $mcItem->Options[0]->Value);
        $this->assertEquals(0, $mcItem->Options[1]->Value);
        $this->assertEquals(0, $mcItem->Options[3]->Value);
    }
    
    /**
     * @covers MoodleImporter\MultipleChoiceItem::ToXMLElement
     */
    public function testToXMLElement() 
    {
        $mcItem = new MultipleChoiceItem;
        $mcItem->Name = "MC 001 - What is";
        $mcItem->PointValue = 2;
        $mcItem->ShuffleAnswers = true;
        $mcItem->Text = "What is the answer to this question?";
        $mcItem->SingleSelection = true;
        $mcItem->AnswerNumbering = "abc";
        
        $option1 = new MultipleChoiceOption;
        $option1->Text = "The correct answer";
        $option1->Value = 100;
        
        $option2 = new MultipleChoiceOption;
        $option2->Text = "A distractor";
        $option2->Value = 0;
        
        $option3 = new MultipleChoiceOption;
        $option3->Text = "Another distractor";
        $option3->Value = 0;

        $mcItem->Options = array($option1, $option2, $option3);
        
        $expected = <<<'MC_XML'
        <question type="multichoice">
            <name>
                <text>MC 001 - What is</text>
            </name>
            <questiontext format="html">
                <text><![CDATA[What is the answer to this question?]]></text>
            </questiontext>
            <answer fraction="100">
               <text>The correct answer</text>
            </answer>
            <answer fraction="0">
                <text>A distractor</text>
            </answer>
            <answer fraction="0">
                <text>Another distractor</text>
            </answer>
            <shuffleanswers>1</shuffleanswers>
            <single>true</single>
            <answernumbering>abc</answernumbering>
            <defaultgrade>2</defaultgrade>
        </question>
MC_XML;
        
        $this->assertTrue(xml_is_equal(new \SimpleXMLElement($expected), $mcItem->ToXMLElement()));
    }

    
    /**
    * 
    * @covers MoodleImporter\MultipleChoiceItem::ToHTML
    * 
    */
    public function testToHTML()
    {
        $mcItem = new MultipleChoiceItem;
        $mcItem->Name = "MC 001 - What is";
        $mcItem->PointValue = 2;
        $mcItem->ShuffleAnswers = true;
        $mcItem->Text = "What is the answer to this question?";
        $mcItem->SingleSelection = true;
        $mcItem->AnswerNumbering = "abc";
        
        $option1 = new MultipleChoiceOption;
        $option1->Text = "The correct answer";
        $option1->Value = 100;
        
        $option2 = new MultipleChoiceOption;
        $option2->Text = "A distractor";
        $option2->Value = 0;
        
        $option3 = new MultipleChoiceOption;
        $option3->Text = "Another distractor";
        $option3->Value = 0;

        $mcItem->Options = array($option1, $option2, $option3);
        
        $expected = <<<'MC_HTML'
        <p>MC 001 - What is</p>
        <p>What is the answer to this question?</p>
        <ol type="A">
            <li><strong>The correct answer</strong></li>
            <li>A distractor</li>
            <li>Another distractor</li>
        </ol>
MC_HTML;
        
        $this->assertTrue(html_is_equal($expected, $mcItem->ToHTML()));

    }

}

?>
