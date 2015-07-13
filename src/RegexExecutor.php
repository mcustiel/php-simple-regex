<?php
namespace Mcustiel\PhpSimpleRegex;

/**
 * @author mcustiel
 *
 */
class RegexExecutor
{
    /**
     * @param string $pattern
     * @param string $subject
     * @param number $offset
     * @return \Mcustiel\PhpSimpleRegex\RegexResponse
     */
    public function execute($pattern, $subject, $offset = 0)
    {
        $matches = array();
        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER, $offset);

        return new RegexResponse($matches);
    }

    public function replaceAndCount($pattern, $replacement, $subject, $limit = -1)
    {
        $count = 0;
        $replaced = preg_replace($pattern, $replacement, $subject, $limit, $count);

        return new ReplaceResponse($replaced, $count);
    }

    public function replace($pattern, $replacement, $subject, $limit = -1)
    {
        return preg_replace($pattern, $replacement, $subject, $limit);
    }

    public function replaceCallback($pattern, callable $callback, $subject, $limit = -1)
    {
        return preg_replace_callback($pattern, $callback, $subject, $limit);
    }

    public function replaceCallbackAndCount($pattern, callable $callback, $subject, $limit = -1)
    {
        $count = 0;
        $result = preg_replace_callback($pattern, $callback, $subject, $limit);

        return new ReplaceResponse($result, $count);
    }
}
