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
namespace Mcustiel\PhpSimpleRegex;

/**
 * Represent the result of a search through a string using a regular expression.
 * This
 * is an iterable collection of matches.
 *
 * @author mcustiel
 */
class MatchResult implements \Iterator
{
    /**
     *
     * @var array
     */
    protected $response;
    /**
     *
     * @var int
     */
    private $current;
    /**
     *
     * @var int
     */
    private $count;

    /**
     * Class contructor.
     *
     * @param array $regexResponse
     */
    public function __construct(array $regexResponse)
    {
        $this->response = $regexResponse;
        $this->count = count($this->response);
        $this->current = 0;
    }

    /**
     * Returns the number of matches found in the subject string for the executed regex.
     *
     * @return int
     */
    public function getMatchesCount()
    {
        return $this->count;
    }

    /**
     * Returns a match for the executed pattern using it's order in the string.
     *
     * @param int $index
     *
     * @throws \OutOfBoundsException
     * @return \Mcustiel\PhpSimpleRegex\Match
     */
    public function getMatchAt($index)
    {
        if (! isset($this->response[$index])) {
            throw new \OutOfBoundsException('Trying to access a match at an invalid index');
        }

        return new Match($this->response[$index]);
    }

    // \Iterable implementation

    /**
     *
     * @return \Mcustiel\PhpSimpleRegex\Match
     */
    public function current()
    {
        return new Match($this->response[$this->current]);
    }

    public function next()
    {
        ++ $this->current;
    }

    public function key()
    {
        return $this->current;
    }

    public function valid()
    {
        return $this->current < $this->count;
    }

    public function rewind()
    {
        $this->current = 0;
    }
}
