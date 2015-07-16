<?php
namespace Test\Mcustiel\PhpSimpleRegex;

use Mcustiel\PhpSimpleRegex\Executor;
use Mcustiel\PhpSimpleRegex\MatchResult;
use Mcustiel\PhpSimpleRegex\Match;

class ExecutorTest extends \PHPUnit_Framework_TestCase
{
    const PATTERN = '/(a|b)\d+/';
    const MATCHING_SUBJECT = 'a12z56b34hzyp5a5opqb9';
    const NOT_MATCHING_SUBJECT = 'abcdefghijklmnopqrstuvwxyz';

    /**
     * @var \Mcustiel\PhpSimpleRegex\Executor
     */
    private $executor;

    /**
     * @before
     */
    public function initExecutor()
    {
        $this->executor = new Executor();
    }

    /**
     * @test
     */
    public function shouldReturnAListOfValidMatchesWhenGetAllMatchesCalledCorrectly()
    {
        $result = $this->executor->getAllMatches(self::PATTERN, self::MATCHING_SUBJECT);
        $this->assertInstanceOf(MatchResult::class, $result);
        $this->assertEquals(4, $result->getMatchesCount());
        $this->assertEquals('a5', $result->getMatchAt(2)->getFullMatch());
        $this->assertEquals('a', $result->getMatchAt(2)->getSubMatchAt(1));
        $this->assertEquals(14, $result->getMatchAt(2)->getSubmatchOffsetAt(1));
    }

    /**
     * @test
     */
    public function shouldReturnAnEmptyListOfMatchesWhenGetAllMatchesDoesNotMatchAnything()
    {
        $result = $this->executor->getAllMatches(self::PATTERN, self::NOT_MATCHING_SUBJECT);
        $this->assertInstanceOf(MatchResult::class, $result);
        $this->assertEquals(0, $result->getMatchesCount());
    }

    /**
     * @test
     */
    public function shouldReturnAMatchesWhenGetOneMatchCalledCorrectly()
    {
        $result = $this->executor->getOneMatch(self::PATTERN, self::MATCHING_SUBJECT);
        $this->assertInstanceOf(Match::class, $result);
        $this->assertEquals('a12', $result->getFullMatch());
        $this->assertEquals('a', $result->getSubMatchAt(1));
        $this->assertEquals(0, $result->getSubmatchOffsetAt(1));
    }

    /**
     * @test
     */
    public function shouldReturnNullWhenGetOneMatchDoesNotMatchAnything()
    {
        $result = $this->executor->getOneMatch(self::PATTERN, self::NOT_MATCHING_SUBJECT);
        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfMatchCalledAndPatternMatch()
    {
        $this->assertTrue($this->executor->match(self::PATTERN, self::MATCHING_SUBJECT));
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfMatchCalledAndPatternDoesNotMatch()
    {
        $this->assertFalse($this->executor->match(self::PATTERN, self::NOT_MATCHING_SUBJECT));
    }

    /**
     * @test
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage An error occurred executing the pattern a^b**z
     */
    public function shouldThrowAnExceptionIfMatchCalledAndPatternIsNotRight()
    {
        $this->assertFalse($this->executor->match('a^b**z', self::NOT_MATCHING_SUBJECT));
    }
}
