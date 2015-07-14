<?php
namespace Test\Mcustiel\PhpSimpleRegex;

use Mcustiel\PhpSimpleRegex\RegexResponse;
use Mcustiel\PhpSimpleRegex\Match;
class RegexResponseTest extends \PHPUnit_Framework_TestCase
{
    const PATTERN = '|(\d{4})-(\d{2})-(\d{2})|';
    const SUBJECT =
        'Date 1: 2015-01-01, Date 2: 2015-02-02, Date 3: 2015-03-03, Date 4: 2015-04-04, Date 5: 2015-05-05';

    private $result;

    /**
     * @before
     */
    public function createRegexResult()
    {
        $result = [];
        preg_match_all(self::PATTERN, self::SUBJECT, $result, PREG_SET_ORDER);
        $this->result = new RegexResponse($result);
    }

    /**
     * @test
     */
    public function shouldGetValidMatchesCount()
    {
        $this->assertEquals(5, $this->result->getMatchesCount());
    }

    /**
     * @test
     */
    public function shouldGetTheCorrectMatchWhenRequested()
    {
        $match = $this->result->getMatchAt(2);
        $this->assertInstanceOf(Match::class, $match);
        $this->assertEquals('2015-03-03', $match->getFullMatch());
    }

    /**
     * @test
     * @expectedException        \OutOfBoundsException
     * @expectedExceptionMessage Trying to access a match at an invalid index
     */
    public function shouldThrowAnExceptionWhenInvalidMatchIsRequested()
    {
        $this->result->getMatchAt(10);
    }

    /**
     * @test
     */
    public function shouldIterateAsAnArray()
    {
        foreach ($this->result as $index => $match) {
            $this->assertInstanceOf(Match::class, $match);
            $this->assertEquals($this->result->getMatchAt($index), $match);
        }
    }
}
