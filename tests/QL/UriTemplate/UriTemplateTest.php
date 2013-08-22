<?php
/**
 * @copyright ©2005—2013 Quicken Loans Inc. All rights reserved. Trade Secret,
 *    Confidential and Proprietary. Any dissemination outside of Quicken Loans
 *    is strictly prohibited.
 */

namespace QL\UriTemplate;

use PHPUnit_Framework_TestCase;
use stdClass;

class UriTemplateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers QL\UriTemplate\UriTemplate
     * @expectedException \QL\UriTemplate\Exception
     */
    public function testConstructingBadUriTemplateThrowsException()
    {
        $expander = new Expander;
        new UriTemplate('/foo/{bar', $expander);
    }

    /**
     * @covers QL\UriTemplate\UriTemplate
     */
    public function testExpandingWithBadVariablesThrowsException()
    {
        $expander = new Expander;

        $tpl = new UriTemplate('/foo/{mytpl}', $expander);

        $thrown = false;
        try {
            $tpl->expand(['mytpl' => new stdClass]);
        } catch (Exception $e) {
            $thrown = true;
        }

        $this->assertTrue($thrown);
    }

    /**
     * @covers QL\UriTemplate\UriTemplate
     */
    public function testGoodExpansionOnUriTemplate()
    {
        $expander = new Expander;
        $tpl = new UriTemplate('/foo/{woot}', $expander);
        $actual = $tpl->expand(['woot' => 'bar']);

        $this->assertSame('/foo/bar', $actual);
    }
}
