<?php
namespace Mcustiel\PhpSimpleRegex\PregFunctions;

use Mcustiel\PhpSimpleRegex\ReplaceResult;

trait ReplaceFunctions
{
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
        $this->checkResultIsOkForReplaceOrThrowException($replaced, $pattern);

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
        // I must display error here, since I couldn't differentiate if error happened or not replace done
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
        $this->checkResultIsOkForReplaceOrThrowException($replaced, $pattern);

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
        // I must display error here, since I couldn't differentiate if error happened or not replace done
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
        $this->checkResultIsOkForReplaceOrThrowException($replaced, $pattern);

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
        $this->checkResultIsOkForReplaceOrThrowException($result, $pattern);

        return new ReplaceResult($result, $count);
    }

    /**
     * @param mixed $pattern
     * @throws \InvalidArgumentException
     * @return string|array
     */
    abstract protected function getPatternForReplace($pattern);

    /**
     * @param mixed  $result
     * @param string $pattern
     *
     * @throws \RuntimeException
     */
    abstract protected function checkResultIsOkForReplaceOrThrowException($result, $pattern);
}
