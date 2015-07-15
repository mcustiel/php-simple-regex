<?php
namespace Mcustiel\PhpSimpleRegex;

/**
 *
 * @author mcustiel
 *
 */
class Match
{
    /**
     *
     * @var array
     */
    protected $element;

    /**
     *
     * @param array $responseElement
     */
    public function __construct(array $responseElement)
    {
        $this->element = $responseElement;
    }

    /**
     *
     * @return mixed
     */
    public function getFullMatch()
    {
        return empty($this->element) ? null : $this->element[0][0];
    }

    /**
     *
     * @param unknown $index
     * @throws \OutOfBoundsException
     * @return mixed
     */
    public function getSubMatchAt($index)
    {
        $this->validateIndex($index);

        return $this->element[$index][0];
    }

    public function getSubmatchOffsetAt($index)
    {
        $this->validateIndex($index);
        return $this->element[$index][1];
    }

    private function validateIndex($index)
    {
        if (! isset($this->element[$index]) || $index == 0) {
            throw new \OutOfBoundsException('Trying to access invalid submatch index');
        }
    }
}
