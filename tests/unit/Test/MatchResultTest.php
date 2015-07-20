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

use Mcustiel\PhpSimpleRegex\Match;
use Mcustiel\PhpSimpleRegex\MatchResult;

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
        preg_match_all(self::PATTERN, self::SUBJECT, $result, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
        $this->result = new MatchResult($result);
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
