<?php
namespace MoodleImporter;

/**
 * XMLUtilities
 * 
 * @package MoodleXMLImporter 
 */


/**
 * Function compares two xml documents to determine if they are conceptually
 * the same, ignoring whitespace. To test for exact matches, including whitespace
 * set the $text_strict parameter to true.
 * 
 * Code retrieved from:
 * @link http://www.jevon.org/wiki/Comparing_Two_SimpleXML_Documents
 * 
 * @param SimpleXMLElement $xml1
 * @param SimpleXMLEleemnt $xml2
 * @param bool $text_strict
 */
function xml_is_equal(\SimpleXMLElement $xml1, \SimpleXMLElement $xml2, $text_strict = false) {
    // compare text content
    if ($text_strict) {
            if ("$xml1" != "$xml2") return "mismatched text content (strict)";
    } else {
            if (trim("$xml1") != trim("$xml2")) return "mismatched text content";
    }

    // check all attributes
    $search1 = array();
    $search2 = array();
    foreach ($xml1->attributes() as $a => $b) {
            $search1[$a] = "$b";		// force string conversion
    }
    foreach ($xml2->attributes() as $a => $b) {
            $search2[$a] = "$b";
    }
    if ($search1 != $search2) return "mismatched attributes";

    // check all namespaces
    $ns1 = array();
    $ns2 = array();
    foreach ($xml1->getNamespaces() as $a => $b) {
            $ns1[$a] = "$b";
    }
    foreach ($xml2->getNamespaces() as $a => $b) {
            $ns2[$a] = "$b";
    }
    if ($ns1 != $ns2) return "mismatched namespaces";

    // get all namespace attributes
    foreach ($ns1 as $ns) {			// don't need to cycle over ns2, since its identical to ns1
            $search1 = array();
            $search2 = array();
            foreach ($xml1->attributes($ns) as $a => $b) {
                    $search1[$a] = "$b";
            }
            foreach ($xml2->attributes($ns) as $a => $b) {
                    $search2[$a] = "$b";
            }
            if ($search1 != $search2) return "mismatched ns:$ns attributes";
    }

    // get all children
    $search1 = array();
    $search2 = array();
    foreach ($xml1->children() as $b) {
            if (!isset($search1[$b->getName()]))
                    $search1[$b->getName()] = array();
            $search1[$b->getName()][] = $b;
    }
    foreach ($xml2->children() as $b) {
            if (!isset($search2[$b->getName()]))
                    $search2[$b->getName()] = array();
            $search2[$b->getName()][] = $b;
    }
    // cycle over children
    if (count($search1) != count($search2)) return "mismatched children count";		// xml2 has less or more children names (we don't have to search through xml2's children too)
    foreach ($search1 as $child_name => $children) {
            if (!isset($search2[$child_name])) return "xml2 does not have child $child_name";		// xml2 has none of this child
            if (count($search1[$child_name]) != count($search2[$child_name])) return "mismatched $child_name children count";		// xml2 has less or more children
            foreach ($children as $child) {
                    // do any of search2 children match?
                    $found_match = false;
                    $reasons = array();
                    foreach ($search2[$child_name] as $id => $second_child) {
                            if (($r = xml_is_equal($child, $second_child)) === true) {
                                    // found a match: delete second
                                    $found_match = true;
                                    unset($search2[$child_name][$id]);
                            } else {
                                    $reasons[] = $r;
                            }
                    }
                    if (!$found_match) return "xml2 does not have specific $child_name child: " . implode("; ", $reasons);
            }
    }

    // finally, cycle over namespaced children 
    foreach ($ns1 as $ns) {			// don't need to cycle over ns2, since its identical to ns1
            // get all children
            $search1 = array();
            $search2 = array();
            foreach ($xml1->children() as $b) {
                    if (!isset($search1[$b->getName()]))
                            $search1[$b->getName()] = array();
                    $search1[$b->getName()][] = $b;
            }
            foreach ($xml2->children() as $b) {
                    if (!isset($search2[$b->getName()]))
                            $search2[$b->getName()] = array();
                    $search2[$b->getName()][] = $b;
            }
            // cycle over children
            if (count($search1) != count($search2)) return "mismatched ns:$ns children count";		// xml2 has less or more children names (we don't have to search through xml2's children too)
            foreach ($search1 as $child_name => $children) {
                    if (!isset($search2[$child_name])) return "xml2 does not have ns:$ns child $child_name";		// xml2 has none of this child
                    if (count($search1[$child_name]) != count($search2[$child_name])) return "mismatched ns:$ns $child_name children count";		// xml2 has less or more children
                    foreach ($children as $child) {
                            // do any of search2 children match?
                            $found_match = false;
                            foreach ($search2[$child_name] as $id => $second_child) {
                                    if (xml_is_equal($child, $second_child) === true) {
                                            // found a match: delete second
                                            $found_match = true;
                                            unset($search2[$child_name][$id]);
                                    }
                            }
                            if (!$found_match) return "xml2 does not have specific ns:$ns $child_name child";
                    }
            }
    }	

    // if we've got through all of THIS, then we can say that xml1 has the same attributes and children as xml2.
    return true;

}

/**
 * This function uses the DOM to make a deep copy of the $from object
 * and inserts it as a child into the $to object.
 * 
 * Code retrieved from: 
 * @link http://stackoverflow.com/questions/4778865/php-simplexml-addchild-with-another-simplexmlelement
 * 
 * @param SimpleXMLElement $to
 * @param SimpleXMLElement $from 
 */
function sxml_append(\SimpleXMLElement $to, \SimpleXMLElement $from) {
    $toDom = dom_import_simplexml($to);
    $fromDom = dom_import_simplexml($from);
    $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
}


/**
 * html_is_equal
 * 
 * Determines whether or not two given html strings are equal, by first
 * cleaning both of them and comparing them as strings.
 * @param string $to
 * @param string $from
 * @return boolean
 */
function html_is_equal($to, $from)
{
    $to1 = preg_replace('~\s*(<([^>]*)>[^<]*</\2>|<[^>]*>)\s*~','$1',$to );
    $from1 = preg_replace('~\s*(<([^>]*)>[^<]*</\2>|<[^>]*>)\s*~','$1',$from);
    if ($to1 != $from1)
    {
        return $to1 . 'does not equal' . $from1;
    }
    else
    {
        return true;
    }
}

/**
 * clean_xml
 * 
 * Function that strips out all the extra whitespace and line endings in an
 * XML file to prepare it for processing.
 * 
 * @param string $xmlFile
 * @return string 
 */
function clean_xml($xmlFile)
{
    //$data = preg_replace('~\s\s+~', ' ', $xmlFile);
    $data = preg_replace('~(\s)*(<([^>]*)>[^<]*</\2>|<[^>]*>)(\s)*~','$1$2$4', $xmlFile);
    $data = str_replace('\r\n', "", $data);
    return $data;
}

/**
 * simplexml_add_CDATA
 * 
 * Function that encloses the $contents parameter inside a CDATA tag and appends
 * it as a child of the $enclosingElement parameter. Appending a CDATA element
 * with SimpleXML's appendChild method throws the CDATA tag away, but we need it
 * when exporting to Moodle XML.
 * 
 * @param \SimpleXMLElement $enclosingElement
 * @param string $contents 
 */
function simplexml_add_CDATA(\SimpleXMLElement $enclosingElement, $contents)
{
    $dom = dom_import_simplexml($enclosingElement);
    $data = $dom->ownerDocument->createCDATASection($contents);
    $dom->appendChild($data);
}

?>
