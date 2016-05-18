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

use Mcustiel\PhpSimpleRegex\PregFunctions\GrepFunctions;
use Mcustiel\PhpSimpleRegex\PregFunctions\MatchFunctions;
use Mcustiel\PhpSimpleRegex\PregFunctions\ReplaceFunctions;
use Mcustiel\PhpSimpleRegex\PregFunctions\SplitFunctions;

/**
 * Facade class that wraps preg_* functions and returns the result of calling this function in an
 * object oriented way when necessary.
 *
 * @author mcustiel
 */
class Executor
{
    use GrepFunctions, MatchFunctions, ReplaceFunctions, SplitFunctions;

    /**
     * @param mixed $pattern
     * @throws \InvalidArgumentException
     * @return string|array
     */
    private function getPatternForReplace($pattern)
    {
        if (is_array($pattern)) {
            return $pattern;
        }

        return $this->getPatternByType($pattern);
    }

    /**
     * @param mixed $pattern
     * @throws \InvalidArgumentException
     * @return string
     */
    private function getPatternByType($pattern)
    {
        if (is_string($pattern)) {
            return $pattern;
        }
        if (is_object($pattern)) {
            if (is_a($pattern, 'SelvinOrtiz\Utils\Flux\Flux')
                || is_a($pattern, 'VerbalExpressions\PHPVerbalExpressions\VerbalExpressions')
                || is_a($pattern, 'MarkWilson\VerbalExpression')) {
                return $pattern->__toString();
            }
        }
        throw new  \InvalidArgumentException(
            'Pattern must be a string, an instance of '
            . 'VerbalExpressions\PHPVerbalExpressions\VerbalExpressions '
            . ', SelvinOrtiz\Utils\Flux\Flux'
            . ' or MarkWilson\VerbalExpression'
        );
    }

    /**
     * @param mixed  $result
     * @param string $pattern
     *
     * @throws \RuntimeException
     */
    private function checkResultIsOkOrThrowException($result, $pattern)
    {
        if ($result === false) {
            throw new \RuntimeException(
                'An error occurred executing the pattern ' . var_export($pattern, true)
            );
        }
    }

    /**
     * @param mixed  $result
     * @param string $pattern
     *
     * @throws \RuntimeException
     */
    private function checkResultIsOkForReplaceOrThrowException($result, $pattern)
    {
        if ($result === null) {
            throw new \RuntimeException(
                'An error occurred replacing the pattern ' . var_export($pattern, true)
            );
        }
    }
}
