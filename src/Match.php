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
     * @return null|string
     */
    public function getFullMatch()
    {
        return empty($this->element) ? null : $this->element[0][0];
    }

    /**
     * @return null|int
     */
    public function getOffset()
    {
        return empty($this->element) ? null : $this->element[0][1];
    }

    /**
     *
     * @param int $index
     * @throws \OutOfBoundsException
     * @return string
     */
    public function getSubMatchAt($index)
    {
        $this->validateIndex($index);

        return $this->element[$index][0];
    }

    /**
     * @param int $index
     * @throws \OutOfBoundsException
     * @return int
     */
    public function getSubmatchOffsetAt($index)
    {
        $this->validateIndex($index);
        return $this->element[$index][1];
    }

    /**
     * @param int $index
     * @throws \OutOfBoundsException
     */
    private function validateIndex($index)
    {
        if (! isset($this->element[$index]) || $index == 0) {
            throw new \OutOfBoundsException('Trying to access invalid submatch index');
        }
    }
}
