<?php
namespace Mcustiel\PhpSimpleRegex\PregFunctions;

use Mcustiel\PhpSimpleRegex\MatchResult;
use Mcustiel\PhpSimpleRegex\Match;

trait MatchFunctions
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
