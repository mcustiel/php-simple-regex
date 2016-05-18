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

class MatchTest extends \PHPUnit_Framework_TestCase
{
    const PATTERN = '|A(\d+)B(\d+)|';
    const SUBJECT = 'A123B456';

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
        preg_match_all(self::PATTERN, self::SUBJECT, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
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
    public function shouldReturnTheOffset()
    {
        $this->assertEquals(0, $this->result->getOffset());
    }

    /**
     * @test
     */
    public function shouldReturnTheOffsetOfTheInnerMatch()
    {
        $this->assertEquals(1, $this->result->getSubmatchOffsetAt(1));
        $this->assertEquals(5, $this->result->getSubmatchOffsetAt(2));
    }

    /**
     * @test
     */
    public function shouldReturnTheInnerMatch()
    {
        $this->assertEquals('123', $this->result->getSubMatchAt(1));
        $this->assertEquals('456', $this->result->getSubMatchAt(2));
    }

    /**
     * @test
     */
    public function shouldReturnTheDefaultIfInnerMatchIsNotSet()
    {
        $this->assertEquals('potato', $this->result->getSubMatchOrDefaultAt(3, 'potato'));
        $this->assertNull($this->result->getSubMatchOrDefaultAt(4));
    }

    /**
     * @test
     * @expectedException        \OutOfBoundsException
     * @expectedExceptionMessage Trying to access invalid submatch index
     */
    public function shouldThrowAnExceptionWhenOffsetIsNotValid()
    {
        $this->result->getSubMatchAt(3);
    }

    /**
     * @test
     * @expectedException        \OutOfBoundsException
     * @expectedExceptionMessage Trying to access invalid submatch index
     */
    public function shouldThrowAnExceptionWhenOffsetIsZero()
    {
        $this->result->getSubMatchAt(0);
    }
}
