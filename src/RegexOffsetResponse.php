<?php
namespace Mcustiel\PhpSimpleRegex;

class RegexOffsetResponse extends RegexResponse
{
/**
     *
     * @param unknown $index
     * @throws \OutOfBoundsException
     * @return \Mcustiel\PhpSimpleRegex\Match
     */
    public function getMatchAt($index)
    {
        if (! isset($this->response[$index])) {
            throw new \OutOfBoundsException('Trying to access a match at an invalid index');
        }

        return new OffsetMatch($this->response[$index]);
    }

    public function current()
    {
        return new OffsetMatch($this->response[$this->current]);
    }
}
