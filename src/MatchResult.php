<?php
namespace Mcustiel\PhpSimpleRegex;

/**
 *
 * @author mcustiel
 *
 */
class MatchResult implements \Iterator
{
    /**
     * @var array
     */
    protected $response;
    /**
     * @var int
     */
    private $current;
    /**
     * @var int
     */
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
     * @return int
     */
    public function getMatchesCount()
    {
        return $this->count;
    }

    /**
     *
     * @param int $index
     * @throws \OutOfBoundsException
     * @return \Mcustiel\PhpSimpleRegex\Match
     */
    public function getMatchAt($index)
    {
        if (!isset($this->response[$index])) {
            throw new \OutOfBoundsException('Trying to access a match at an invalid index');
        }

        return new Match($this->response[$index]);
    }

    /**
     * @return \Mcustiel\PhpSimpleRegex\Match
     */
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
