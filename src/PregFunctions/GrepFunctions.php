<?php
namespace Mcustiel\PhpSimpleRegex\PregFunctions;

trait GrepFunctions
{
    /**
     * Return all strings in the array that match the given regex.
     *
     * @param string|array|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux|MarkWilson\VerbalExpression
     *          $pattern
     * @param array
     *          $input
     *
     * @throws \InvalidArgumentException
     * @return array
     */
    public function grep($pattern, $input)
    {
        $result = @preg_grep($this->getPatternByType($pattern), $input);
        $this->checkResultIsOkOrThrowException($result, $pattern);

        return $result;
    }

    /**
     * Return all strings in the array that do not match the given regex.
     *
     * @param string|array|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux|MarkWilson\VerbalExpression
     *          $pattern
     * @param array
     *          $input
     *
     * @throws \InvalidArgumentException
     * @return array
     */
    public function grepNotMatching($pattern, $input)
    {
        $result = @preg_grep($this->getPatternByType($pattern), $input, PREG_GREP_INVERT);
        $this->checkResultIsOkOrThrowException($result, $pattern);

        return $result;
    }

    /**
     * @param mixed $pattern
     * @throws \InvalidArgumentException
     * @return string
     */
    abstract protected function getPatternByType($pattern);

    /**
     * @param mixed  $result
     * @param string $pattern
     *
     * @throws \RuntimeException
     */
    abstract protected function checkResultIsOkOrThrowException($result, $pattern);
}
