<?php
namespace Mcustiel\PhpSimpleRegex;

/**
 *
 * @author mcustiel
 *
 */
class MatchResult implements \Iterator
{
    protected $response;
    private $current;
    private $count;

    /**
     *
     * @param array $regex
     */
    public function __construct(array $regexResponse)
    {
        $this->response = $regexResponse;
        $this->count = count($this->response);
        $this->current = 0;
    }

    /**
     *
     * @return number
     */
    public function getMatchesCount()
    {
        return $this->count;
    }

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

        return new Match($this->response[$index]);
    }

    public function current()
    {
        return new Match($this->response[$this->current]);
    }

    public function next()
    {
        ++ $this->current;
    }

    public function key()
    {
        return $this->current;
    }

    public function valid()
    {
        return $this->current < $this->count;
    }

    public function rewind()
    {
        $this->current = 0;
    }
}
