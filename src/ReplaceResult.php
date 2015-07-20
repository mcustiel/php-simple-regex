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
 * Represents the result of calling a preg_replace_* function and requesting the count of replacements.
 *
 * @author mcustiel
 * @codeCoverageIgnore
 */
class ReplaceResult
{
    /**
     * @var string
     */
    private $result;
    /**
     * @var integer
     */
    private $replacements;

    /**
     * Class constructor.
     *
     * @param string $result
     * @param integer $replacements
     */
    public function __construct($result, $replacements)
    {
        $this->result = $result;
        $this->replacements = $replacements;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return number
     */
    public function getReplacements()
    {
        return $this->replacements;
    }
}
