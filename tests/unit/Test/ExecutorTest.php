<?php
/**
 * This file is part of php-simple-regex.
 *
 * php-simple-regex is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * php-simple-regex is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with php-simple-regex.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Test\Mcustiel\PhpSimpleRegex;

use Mcustiel\PhpSimpleRegex\Executor;
use Mcustiel\PhpSimpleRegex\MatchResult;
use Mcustiel\PhpSimpleRegex\Match;
use Mcustiel\PhpSimpleRegex\ReplaceResult;
use VerbalExpressions\PHPVerbalExpressions\VerbalExpressions as PhpVerbalExpressions;
use SelvinOrtiz\Utils\Flux\Flux;
use MarkWilson\VerbalExpression as VerbalExpressionsPhp;

class ExecutorTest extends \PHPUnit_Framework_TestCase
{
    const PATTERN = '/(a|b)\d+/';
    const MATCHING_SUBJECT = 'a12z56b34hzyp5a5opqb9';
    const NOT_MATCHING_SUBJECT = 'abcdefghijklmnopqrstuvwxyz';
    const INVALID_PATTERN = 'a^b**z';

    /**
     *
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
     * @expectedExceptionMessage An error occurred executing the pattern 'a^b**z'
     */
    public function shouldThrowAnExceptionIfMatchCalledAndPatternIsNotRight()
    {
        $this->executor->match(self::INVALID_PATTERN, self::NOT_MATCHING_SUBJECT);
    }

    /**
     * @test
     */
    public function shouldReplaceAndReturnResultAndReplacementCounts()
    {
        $result = $this->executor->replaceAndCount(self::PATTERN, 'potato', self::MATCHING_SUBJECT);

        $this->assertInstanceOf(ReplaceResult::class, $result);
        $this->assertEquals(4, $result->getReplacements());
        $this->assertEquals('potatoz56potatohzyp5potatoopqpotato', $result->getResult());
    }

    /**
     * @test
     */
    public function shouldReplaceAndReturnResultAndReplacementCountsWhenCalledWithAnArray()
    {
        $result = $this->executor->replaceAndCount(
            self::PATTERN,
            'potato',
            [self::MATCHING_SUBJECT, self::MATCHING_SUBJECT, self::NOT_MATCHING_SUBJECT]
        );

        $this->assertInstanceOf(ReplaceResult::class, $result);
        $this->assertEquals(8, $result->getReplacements());
        $array = $result->getResult();
        $this->assertInternalType('array', $array);
        $this->assertEquals(3, count($array));
        $this->assertEquals('potatoz56potatohzyp5potatoopqpotato', $array[0]);
        $this->assertEquals('potatoz56potatohzyp5potatoopqpotato', $array[1]);
        $this->assertEquals(self::NOT_MATCHING_SUBJECT, $array[2]);
    }

    /**
     * @test
     */
    public function shouldReturnSameStringAndCountZeroWhenReplacementPatternDoesNotMatch()
    {
        $result = $this->executor->replaceAndCount(self::PATTERN, 'potato', self::NOT_MATCHING_SUBJECT);

        $this->assertInstanceOf(ReplaceResult::class, $result);
        $this->assertEquals(0, $result->getReplacements());
        $this->assertEquals(self::NOT_MATCHING_SUBJECT, $result->getResult());
    }

    /**
     * @test
     */
    public function shouldReturnStringIfCountIsNotRequired()
    {
        $result = $this->executor->replace(self::PATTERN, 'potato', self::MATCHING_SUBJECT);
        $this->assertEquals('potatoz56potatohzyp5potatoopqpotato', $result);
    }

    /**
     * @test
     */
    public function shouldReplaceAllMatchesWhenCalledWithArrayOfPatterns()
    {
        $result = $this->executor->replace([self::PATTERN, '/\_\d/'], 'potato', 'anb_12a11_2b34');
        $this->assertEquals('anbpotato2potatopotatopotato', $result);
    }

    /**
     * @test
     */
    public function shouldReturnArrayIfReplacingArray()
    {
        $result = $this->executor->replace(
            self::PATTERN,
            'potato',
            [self::MATCHING_SUBJECT, self::NOT_MATCHING_SUBJECT]
        );
        $this->assertInternalType('array', $result);
        $this->assertEquals('potatoz56potatohzyp5potatoopqpotato', $result[0]);
        $this->assertEquals(self::NOT_MATCHING_SUBJECT, $result[1]);
    }

    /**
     * @test
     */
    public function shouldReturnSameStringIfCountIsNotRequiredAndPatternDoesNotMatch()
    {
        $result = $this->executor->replace(self::PATTERN, 'potato', self::NOT_MATCHING_SUBJECT);
        $this->assertEquals(self::NOT_MATCHING_SUBJECT, $result);
    }

    /**
     * @test
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage An error occurred replacing the pattern 'a^b**z'
     */
    public function shouldThrowAnExceptionIfReplacePatternIsNotRight()
    {
        $this->executor->replace(self::INVALID_PATTERN, 'potato', self::NOT_MATCHING_SUBJECT);
    }

    /**
     * @test
     */
    public function shouldReturnReplacemedStringUsingCallback()
    {
        $replaced = $this->executor->replaceCallback(
            self::PATTERN,
            function ($matches) {
                if ($matches[1] == 'a') {
                    return 'potato';
                }
                return 'banana';
            },
            self::MATCHING_SUBJECT
        );
        $this->assertEquals('potatoz56bananahzyp5potatoopqbanana', $replaced);
    }

    /**
     * @test
     */
    public function shouldReturnSameStringUsingCallbackWhenPatternDoesNotMatch()
    {
        $replaced = $this->executor->replaceCallback(
            self::PATTERN,
            function ($matches) {
                if ($matches[1] == 'a') {
                    return 'potato';
                }
                return 'banana';
            },
            self::NOT_MATCHING_SUBJECT
            );
        $this->assertEquals(self::NOT_MATCHING_SUBJECT, $replaced);
    }

    /**
     * @test
     */
    public function shouldReturnReplacemedStringAndReplacementCountUsingCallback()
    {
        $result = $this->executor->replaceCallbackAndCount(
            self::PATTERN,
            function ($matches) {
                if ($matches[1] == 'a') {
                    return 'potato';
                }
                return 'banana';
            },
            self::MATCHING_SUBJECT
        );

        $this->assertInstanceOf(ReplaceResult::class, $result);
        $this->assertEquals(4, $result->getReplacements());
        $this->assertEquals('potatoz56bananahzyp5potatoopqbanana', $result->getResult());
    }

    /**
     * @test
     */
    public function shouldReturnStringAndReplacementCountsIfStringIsChanged()
    {
        $result = $this->executor->replaceAndCountAndOnlyGetChanged(
            self::PATTERN, 'potato', self::MATCHING_SUBJECT
        );
        $this->assertInstanceOf(ReplaceResult::class, $result);
        $this->assertEquals(4, $result->getReplacements());
        $this->assertEquals('potatoz56potatohzyp5potatoopqpotato', $result->getResult());
    }

    /**
     * @test
     */
    public function shouldReturnOnlyChangedStringAndReplacementCountsIfStringMatchInArray()
    {
        $result = $this->executor->replaceAndCountAndOnlyGetChanged(
            self::PATTERN, 'potato', [self::MATCHING_SUBJECT, self::NOT_MATCHING_SUBJECT]
            );
        $this->assertInstanceOf(ReplaceResult::class, $result);
        $this->assertEquals(4, $result->getReplacements());
        $this->assertInternalType('array', $result->getResult());
        $this->assertEquals(1, count($result->getResult()));
        $this->assertEquals('potatoz56potatohzyp5potatoopqpotato', $result->getResult()[0]);
    }

    /**
     * @test
     */
    public function shouldReturnStringNullAndReplacementCountsZeroIfStringDoesNotMatch()
    {
        $result = $this->executor->replaceAndCountAndOnlyGetChanged(
            self::PATTERN, 'potato', self::NOT_MATCHING_SUBJECT
        );
        $this->assertInstanceOf(ReplaceResult::class, $result);
        $this->assertEquals(0, $result->getReplacements());
        $this->assertNull($result->getResult());
    }

    /**
     * @test
     */
    public function shouldReturnEmptyArrayAndReplacementCountsZeroIfNoMatchInArray()
    {
        $result = $this->executor->replaceAndCountAndOnlyGetChanged(
            self::PATTERN, 'potato', [self::NOT_MATCHING_SUBJECT, self::NOT_MATCHING_SUBJECT]
            );
        $this->assertInstanceOf(ReplaceResult::class, $result);
        $this->assertEquals(0, $result->getReplacements());
        $this->assertInternalType('array', $result->getResult());
        $this->assertEquals(0, count($result->getResult()));
    }

    /**
    * @test
    */
    public function shouldWorkWhenCalledWithPhpVerbalExpressions()
    {
        $regex = new PhpVerbalExpressions();
        $regex->add('(a|b)')->add('\d+');

        $result = $this->executor->getAllMatches($regex, self::MATCHING_SUBJECT);
        $this->assertInstanceOf(MatchResult::class, $result);
        $this->assertEquals(4, $result->getMatchesCount());
        $this->assertEquals('a5', $result->getMatchAt(2)->getFullMatch());
        $this->assertEquals('a', $result->getMatchAt(2)->getSubMatchAt(1));
        $this->assertEquals(14, $result->getMatchAt(2)->getSubmatchOffsetAt(1));
    }

    /**
     * @test
     */
    public function shouldWorkWhenCalledWithFlux()
    {
        $regex = Flux::getInstance()
            ->either('a', 'b')
            ->digits();
        $result = $this->executor->getAllMatches($regex, self::MATCHING_SUBJECT);
        $this->assertInstanceOf(MatchResult::class, $result);
        $this->assertEquals(4, $result->getMatchesCount());
        $this->assertEquals('a5', $result->getMatchAt(2)->getFullMatch());
        $this->assertEquals('a', $result->getMatchAt(2)->getSubMatchAt(1));
        $this->assertEquals(14, $result->getMatchAt(2)->getSubmatchOffsetAt(1));
    }

    /**
     * @test
     */
    public function shouldWorkWhenCalledWithVerbalExpressionPhp()
    {
        $regex = new VerbalExpressionsPhp();
        $regex->add('(a|b)')->add('\d+');

        $result = $this->executor->getAllMatches($regex, self::MATCHING_SUBJECT);
        $this->assertInstanceOf(MatchResult::class, $result);
        $this->assertEquals(4, $result->getMatchesCount());
        $this->assertEquals('a5', $result->getMatchAt(2)->getFullMatch());
        $this->assertEquals('a', $result->getMatchAt(2)->getSubMatchAt(1));
        $this->assertEquals(14, $result->getMatchAt(2)->getSubmatchOffsetAt(1));
    }

    /**
     * @test
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage
     *      Pattern must be a string, an instance of \
     *      VerbalExpressions\PHPVerbalExpressions\VerbalExpressions\
     *      or an instance of SelvinOrtiz\Utils\Flux\Flux'
     */
    public function shouldThrowExceptionWhenCalledWithInvalidPatternType()
    {
        $object = new \stdClass();
        $object->potato = 'banana';
        $result = $this->executor->getAllMatches($object, self::MATCHING_SUBJECT);
        $this->assertInstanceOf(MatchResult::class, $result);
        $this->assertEquals(4, $result->getMatchesCount());
        $this->assertEquals('a5', $result->getMatchAt(2)->getFullMatch());
        $this->assertEquals('a', $result->getMatchAt(2)->getSubMatchAt(1));
        $this->assertEquals(14, $result->getMatchAt(2)->getSubmatchOffsetAt(1));
    }
}
