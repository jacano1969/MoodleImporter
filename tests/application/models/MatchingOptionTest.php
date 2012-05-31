<?php

namespace MoodleImporter;
if (!defined('APPPATH'))
{
    define('APPPATH', dirname(__FILE__) . '/../../../application');
}

require_once APPPATH . '/models/Quiz.php';

/**
 * Test class for MultipleChoiceOption.
 * Generated by PHPUnit on 2012-05-20 at 08:13:31.
 */
class MatchingOptionTest extends \PHPUnit_Framework_TestCase {

   
    /**
     * @covers MoodleImporter\MultipleChoiceOption::ToXMLElement
     */
    public function testToXMLElement() 
    {
        $option = new MatchingOption;
        $option->Text = "Alabama";
        $option->Value = "State starting with an A";
        $expected = <<<OPTION_XML
        <subquestion>
            <text>
                <![CDATA[Alabama]]>
            </text>
            <answer>
                <![CDATA[State starting with an A]]>
            </answer>
        </subquestion>
OPTION_XML;
        $this->assertTrue(xml_is_equal($option->ToXMLElement(), new \SimpleXMLElement($expected)));
    }

    /**
     * @covers MoodleImporter\MultipleChoiceOption::ToHTML() 
     */
    public function testToHTML()
    {
        $option = new MatchingOption;
        $option->Text = "Alabama";
        $option->Value = "State starting with an A";
        $expected = <<<OPTION_XML
            <dt>Alabama</dt><dd>State starting with an A</dd>
OPTION_XML;
        $this->assertTrue(html_is_equal($expected, $option->ToHTML()));
        
    }
    
    public function testConstruct()
    {
        $mtOption = new MatchingOption("Term", "Definition");
        $this->assertEquals("Term", $mtOption->Text);
        $this->assertEquals("Definition", $mtOption->Value);
    }
}

?>
