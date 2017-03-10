<?php
namespace Mcustiel\PhpSimpleRegex\PregFunctions;

trait SplitFunctions
{

    /**
     * Splits a string using the given regular expression as separator.
     * See @link http://php.net/manual/es/function.preg-split.php
     *
     * @param string|array|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux|MarkWilson\VerbalExpression
     *          $pattern
     * @param string
     *          $string
     * @param integer
     *          $limit
     * @param boolean
     *          $returnOnlyNotEmpty
     * @param boolean
     *          $captureOffset
     * @param boolean
     *          $captureSubpatterns
     *
     * @throws \InvalidArgumentException
     * @return array
     */
    public function split(
        $pattern,
        $string,
        $limit = -1,
        $returnOnlyNotEmpty = false,
        $captureOffset = false,
        $captureSubpatterns = false
    ) {
        $result = @preg_split(
            $this->getPatternByType($pattern),
            $string,
            $limit,
            ($returnOnlyNotEmpty ? PREG_SPLIT_NO_EMPTY : 0)
            | ($captureOffset ? PREG_SPLIT_OFFSET_CAPTURE : 0)
            | ($captureSubpatterns ? PREG_SPLIT_DELIM_CAPTURE : 0)
        );
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
