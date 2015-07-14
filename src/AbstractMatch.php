<?php
namespace Mcustiel\PhpSimpleRegex;

abstract class AbstractMatch
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
        return empty($this->element) ? null : $this->element[0];
    }
}
