<?php
namespace Mcustiel\PhpSimpleRegex;

/**
 * @author mcustiel
 *
 */
class Match extends \ArrayIterator
{
    /**
     * @param array $responseElement
     */
    public function __construct(array $responseElement)
    {
        parent::__construct($responseElement);
    }

    /**
     * @return mixed
     */
    public function getFullMatch()
    {
        return parent::offsetGet(0);
    }

    /**
     * @param unknown $index
     * @throws \OutOfBoundsException
     * @return mixed
     */
    public function getMatchAt($index)
    {
        if (!parent::offsetExists($index)) {
            throw new \OutOfBoundsException('Trying to access invalid submatch index');
        }

        return parent::offsetGet($index);
    }
}
