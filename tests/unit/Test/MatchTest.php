<?php
namespace Test\Mcustiel\PhpSimpleRegex;

use Mcustiel\PhpSimpleRegex\Match;

class MatchTest extends \PHPUnit_Framework_TestCase
{
    const PATTERN = '|A(\d+)B|';
    const SUBJECT = 'A123456B';

    /**
     * @var \Mcustiel\PhpSimpleRegex\Match
     */
    private $result;

    /**
     * @before
     */
    public function buildResult()
    {
        $matches = array();
        preg_match_all(self::PATTERN, self::SUBJECT, $matches, PREG_SET_ORDER);
        $this->result = new Match($matches[0]);
    }

    /**
     * @test
     */
    public function shouldReturnTheFullMatch()
    {
        $this->assertEquals(self::SUBJECT, $this->result->getFullMatch());
    }

    /**
     * @test
     */
    public function shouldReturnTheInnerMatch()
    {
        $this->assertEquals('123456', $this->result->getMatchAt(1));
    }

    /**
     * @test
     * @expectedException        \OutOfBoundsException
     * @expectedExceptionMessage Trying to access invalid submatch index
     */
    public function shouldThrowAnExceptionWhenOffsetIsNotValid()
    {
        $this->result->getMatchAt(2);
    }
}
