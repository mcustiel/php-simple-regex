<?php
namespace Mcustiel\PhpSimpleRegex;

/**
 * Represents a match in a collection of matches obtained of checking a string against
 * a regular expression.
 *
 * @author mcustiel
 */
class Match
{
    /**
     *
     * @var array
     */
    protected $element;

    /**
     * Class constructor.
     *
     * @param array $responseElement
     */
    public function __construct(array $responseElement)
    {
        $this->element = $responseElement;
    }

    /**
     * Returns the full match string that matches the whole pattern. Null if no match found.
     *
     * @return null|string
     */
    public function getFullMatch()
    {
        return empty($this->element) ? null : $this->element[0][0];
    }

    /**
     * Returns the offset of the string that matches the whole pattern in the subject
     * string, null if no match found.
     *
     * @return null|int
     */
    public function getOffset()
    {
        return empty($this->element) ? null : $this->element[0][1];
    }

    /**
     * Returns the string matching a subpattern of a pattern, giving it's index.
     *
     * @param int $index
     *
     * @throws \OutOfBoundsException
     * @return string
     */
    public function getSubMatchAt($index)
    {
        $this->validateIndex($index);

        return $this->element[$index][0];
    }

    /**
     * Returns the offset of the string matching a subpattern of a pattern, giving it's index.
     *
     * @param int $index
     *
     * @throws \OutOfBoundsException
     * @return int
     */
    public function getSubmatchOffsetAt($index)
    {
        $this->validateIndex($index);
        return $this->element[$index][1];
    }

    /**
     * Validates the index of a subpattern.
     *
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
