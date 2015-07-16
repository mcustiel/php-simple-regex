<?php
namespace Mcustiel\PhpSimpleRegex;

/**
 *
 * @author mcustiel
 *
 */
class Executor
{
    /**
     *
     * @param string|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux
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
     * @param string|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux
     *          $pattern
     * @param string
     *          $subject
     * @param number
     *          $offset
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return \Mcustiel\PhpSimpleRegex\MatchResult|NULL
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
     * @param string|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux
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
     * @param string|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux
     *          $pattern
     * @param string
     *          $replacement
     * @param string
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
        $replaced = preg_replace($this->getPatternByType($pattern), $replacement, $subject, $limit, $count);

        return new ReplaceResult($replaced, $count);
    }

    /**
     * @param string|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux
     *          $pattern
     * @param string
     *          $replacement
     * @param string
     *          $subject
     * @param number
     *          $limit
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function replace($pattern, $replacement, $subject, $limit = -1)
    {
        return preg_replace($this->getPatternByType($pattern), $replacement, $subject, $limit);
    }

    /**
     * @param string|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux
     *          $pattern
     * @param callable
     *          $callback
     * @param string
     *          $subject
     * @param number
     *          $limit
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function replaceCallback($pattern, callable $callback, $subject, $limit = -1)
    {
        return preg_replace_callback($this->getPatternByType($pattern), $callback, $subject, $limit);
    }

    /**
     * @param string|\VerbalExpressions\PHPVerbalExpressions\VerbalExpressions|SelvinOrtiz\Utils\Flux\Flux
     *          $pattern
     * @param callable
     *          $callback
     * @param string
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
        $result = preg_replace_callback($this->getPatternByType($pattern), $callback, $subject, $limit);

        return new ReplaceResult($result, $count);
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
                || $class == 'VerbalExpressions\PHPVerbalExpressions\VerbalExpressions') {
                return $pattern->__toString();
            }
        }
        throw new  \InvalidArgumentException(
            'Pattern must be a string, an instance of '
            . 'VerbalExpressions\PHPVerbalExpressions\VerbalExpressions '
            . ' or an instance of SelvinOrtiz\Utils\Flux\Flux'
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
            throw new \RuntimeException('An error occurred executing the pattern ' . $pattern);
        }
    }
}
