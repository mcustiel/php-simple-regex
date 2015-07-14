<?php
namespace Mcustiel\PhpSimpleRegex;

/**
 *
 * @author mcustiel
 *
 */
class Match extends AbstractMatch
{
    /**
     *
     * @param unknown $index
     * @throws \OutOfBoundsException
     * @return mixed
     */
    public function getSubMatchAt($index)
    {
        if (! isset($this->element[$index]) || $index == 0) {
            throw new \OutOfBoundsException('Trying to access invalid submatch index');
        }

        return $this->element[$index];
    }
}
