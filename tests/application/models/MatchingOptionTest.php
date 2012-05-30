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
//    public function testToXMLElement() 
//    {
//        $multipleChoiceOption = new MatchingOption;
//        $multipleChoiceOption->Text = "Alabama";
//        $multipleChoiceOption->Value = 100;
//        $expected = <<<OPTION_XML
//        <answer fraction="100">
//            <text><![CDATA[Alabama]]></text>
//        </answer>
//OPTION_XML;
//        $this->assertTrue(xml_is_equal($multipleChoiceOption->ToXMLElement(), new \SimpleXMLElement($expected), true));
//    }

    /**
     * @covers MoodleImporter\MultipleChoiceOption::ToHTML() 
     */
//    public function testToHTML()
//    {
//        $multipleChoiceOption = new MatchingOption;
//        $multipleChoiceOption->Text = "Alabama";
//        $multipleChoiceOption->Value = "State starting with an A";
//        $expected = <<<OPTION_XML
//            <dt>Alabama</dt><dd>State starting with an A</dd>
//OPTION_XML;
//        $this->assertXmlStringEqualsXmlString($expected, $multipleChoiceOption->ToHTML());
//        
//    }
    
    public function testConstruct()
    {
        $mtOption = new MatchingOption("Term", "Definition");
        $this->assertEquals("Term", $mtOption->Text);
        $this->assertEquals("Definition", $mtOption->Value);
    }
}

?>
