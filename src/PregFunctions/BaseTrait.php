<?php
namespace Mcustiel\PhpSimpleRegex\PregFunctions;

trait BaseTrait
{
    /**
     * @param mixed  $result
     * @param string $pattern
     *
     * @throws \RuntimeException
     */
    protected function checkResultIsOkOrThrowException($result, $pattern)
    {
        if ($result === false) {
            throw new \RuntimeException(
                'An error occurred executing the pattern ' . var_export($pattern, true)
            );
        }
    }

    /**
     * @param mixed $pattern
     * @throws \InvalidArgumentException
     * @return string|array
     */
    protected function getPatternForReplace($pattern)
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
    protected function getPatternByType($pattern)
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
}
