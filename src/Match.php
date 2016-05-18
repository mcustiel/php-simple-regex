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
 * Represents a match in a collection of matches obtained of checking a string against
 * a regular expression.
 *
 * @author mcustiel
 */
class Match
{
    /**
     *
     * @var array
     */
    protected $element;

    /**
     * Class constructor.
     *
     * @param array $responseElement
     */
    public function __construct(array $responseElement)
    {
        $this->element = $responseElement;
    }

    /**
     * Returns the full match string that matches the whole pattern. Null if no match found.
     *
     * @return null|string
     */
    public function getFullMatch()
    {
        return empty($this->element) ? null : $this->element[0][0];
    }

    /**
     * Returns the offset of the string that matches the whole pattern in the subject
     * string, null if no match found.
     *
     * @return null|int
     */
    public function getOffset()
    {
        return empty($this->element) ? null : $this->element[0][1];
    }

    /**
     * Returns the string matching a subpattern of a pattern, giving it's index.
     *
     * @param int $index
     *
     * @throws \OutOfBoundsException
     * @return string
     */
    public function getSubMatchAt($index)
    {
        $this->validateIndex($index);

        return $this->element[$index][0];
    }

    /**
     * Returns the string matching a subpattern of a pattern, giving it's index. If there
     * is no submatch at that index, return the default value.
     *
     * @param int $index
     *
     * @return string|mixed
     */
    public function getSubMatchOrDefaultAt($index, $default = null)
    {
        return isset($this->element[$index][0]) ? $this->element[$index][0] : $default;
    }

    /**
     * Returns the offset of the string matching a subpattern of a pattern, giving it's index.
     *
     * @param int $index
     *
     * @throws \OutOfBoundsException
     * @return int
     */
    public function getSubmatchOffsetAt($index)
    {
        $this->validateIndex($index);
        return $this->element[$index][1];
    }

    /**
     * Validates the index of a subpattern.
     *
     * @param int $index
     * @throws \OutOfBoundsException
     */
    private function validateIndex($index)
    {
        if (! isset($this->element[$index]) || $index == 0) {
            throw new \OutOfBoundsException('Trying to access invalid submatch index');
        }
    }
}
