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
 * Facade class that wraps preg_* functions and returns the result of calling this function in an
 * object oriented way when necessary.
 *
 * @author mcustiel
 */
class Executor
{
    /**
     * Searches for all matches for the given pattern.
     *
     * @param string|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux|MarkWilson\VerbalExpression
     *          $pattern
     * @param string
     *          $subject
     * @param number
     *          $offset
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return \Mcustiel\PhpSimpleRegex\MatchResult
     */
    public function getAllMatches($pattern, $subject, $offset = 0)
    {
        $matches = array();
        $result = @preg_match_all(
            $this->getPatternByType($pattern),
            $subject,
            $matches,
            PREG_SET_ORDER | PREG_OFFSET_CAPTURE,
            $offset
        );

        $this->checkResultIsOkOrThrowException($result, $pattern);

        return new MatchResult($matches);
    }

    /**
     * Searches for matches for the given pattern and returns the first match.
     *
     * @param string|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux|MarkWilson\VerbalExpression
     *          $pattern
     * @param string
     *          $subject
     * @param number
     *          $offset
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return \Mcustiel\PhpSimpleRegex\Match|NULL
     */
    public function getOneMatch($pattern, $subject, $offset = 0)
    {
        $matches = array();
        $pattern = $this->getPatternByType($pattern);
        $result = @preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE, $offset);
        $this->checkResultIsOkOrThrowException($result, $pattern);
        return $result? new Match($matches) : null;
    }

    /**
     * Checks weather the string matches the given pattern.
     *
     * @param string|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux|MarkWilson\VerbalExpression
     *          $pattern
     * @param string
     *          $subject
     * @param number
     *          $offset
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return boolean
     */
    public function match($pattern, $subject, $offset = 0)
    {
        $matches = [];
        $result = @preg_match(
            $this->getPatternByType($pattern),
            $subject,
            $matches,
            0,
            $offset
        );
        $this->checkResultIsOkOrThrowException($result, $pattern);
        return (boolean) $result;
    }

    /**
     * Replaces all occurrences of $pattern with $replacement in $subject and returns the result and number
     * of replacements done.
     * See @link http://php.net/manual/en/function.preg-replace.php
     *
     * @param string|array|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux|MarkWilson\VerbalExpression
     *          $pattern
     * @param string
     *          $replacement
     * @param string|array
     *          $subject
     * @param number
     *          $limit
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return \Mcustiel\PhpSimpleRegex\ReplaceResult
     */
    public function replaceAndCount($pattern, $replacement, $subject, $limit = -1)
    {
        $count = 0;
        $replaced = @preg_replace(
            $this->getPatternForReplace($pattern),
            $replacement,
            $subject,
            $limit,
            $count
        );

        if ($replaced === null) {
            throw new \RuntimeException(
                'An error occurred replacing the pattern ' . var_export($pattern, true)
            );
        }

        return new ReplaceResult($replaced, $count);
    }

    /**
     * Replaces all occurrences of $pattern with $replacement in $subject and returns the result and number
     * of replacements done. Result will return only the modified subjects.
     * See @link http://php.net/manual/en/function.preg-filter.php
     *
     * @param string|array|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux|MarkWilson\VerbalExpression
     *          $pattern
     * @param string
     *          $replacement
     * @param string|array
     *          $subject
     * @param number
     *          $limit
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return \Mcustiel\PhpSimpleRegex\ReplaceResult
     */
    public function replaceAndCountAndOnlyGetChanged($pattern, $replacement, $subject, $limit = -1)
    {
        $count = 0;
        // I must display error here, since I couldn't find a way to detect if error happened
        $replaced = preg_filter(
            $this->getPatternForReplace($pattern),
            $replacement,
            $subject,
            $limit,
            $count
        );

        return new ReplaceResult($replaced, $count);
    }

    /**
     * Replaces all occurrences of $pattern with $replacement in $subject and returns the replaced subject.
     *
     * @param string|array|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux|MarkWilson\VerbalExpression
     *          $pattern
     * @param string
     *          $replacement
     * @param string|array
     *          $subject
     * @param number
     *          $limit
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return string|array
     */
    public function replace($pattern, $replacement, $subject, $limit = -1)
    {
        $replaced = @preg_replace(
            $this->getPatternForReplace($pattern),
            $replacement,
            $subject,
            $limit
        );
        if ($replaced === null) {
            throw new \RuntimeException(
                'An error occurred replacing the pattern ' . var_export($pattern, true)
            );
        }

        return $replaced;
    }

    /**
     * Replaces all occurrences of $pattern with $replacement in $subject and returns the replaced subject.
     *
     * @param string|array|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux|MarkWilson\VerbalExpression
     *          $pattern
     * @param string
     *          $replacement
     * @param string|array
     *          $subject
     * @param number
     *          $limit
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return string|array
     */
    public function replaceAndOnlyGetChanged($pattern, $replacement, $subject, $limit = -1)
    {
        // I must display error here, since I couldn't find a way to detect if error happened
        return preg_filter(
            $this->getPatternForReplace($pattern),
            $replacement,
            $subject,
            $limit
        );
    }

    /**
     * Replaces all occurrences of $pattern using $callback function in $subject
     * and returns the replaced subject.
     *
     * @param string|array|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux|MarkWilson\VerbalExpression
     *          $pattern
     * @param callable
     *          $callback
     * @param string|array
     *          $subject
     * @param number
     *          $limit
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return string|array
     */
    public function replaceCallback($pattern, callable $callback, $subject, $limit = -1)
    {
        $replaced = @preg_replace_callback(
            $this->getPatternForReplace($pattern),
            $callback,
            $subject,
            $limit
        );
        if ($replaced === null) {
            throw new \RuntimeException(
                'An error occurred replacing the pattern ' . var_export($pattern, true)
            );
        }

        return $replaced;
    }

    /**
     * Replaces all occurrences of $pattern using $callback function in $subject
     * and returns the replaced subject and the number of replacements done.
     *
     * @param string|array|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux|MarkWilson\VerbalExpression
     *          $pattern
     * @param callable
     *          $callback
     * @param string|array
     *          $subject
     * @param number
     *          $limit
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return \Mcustiel\PhpSimpleRegex\ReplaceResult
     */
    public function replaceCallbackAndCount($pattern, callable $callback, $subject, $limit = -1)
    {
        $count = 0;
        $result = preg_replace_callback(
            $this->getPatternForReplace($pattern),
            $callback,
            $subject,
            $limit,
            $count
        );

        return new ReplaceResult($result, $count);
    }

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
            $class = get_class($pattern);
            if ($class == 'SelvinOrtiz\Utils\Flux\Flux'
                || $class == 'VerbalExpressions\PHPVerbalExpressions\VerbalExpressions'
                || $class == 'MarkWilson\VerbalExpression') {
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
     * @param string $pattern
     * @param boolean $result
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
}
