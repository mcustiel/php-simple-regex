<?php
namespace Mcustiel\PhpSimpleRegex;

/**
 * @author mcustiel
 */
class ReplaceResponse
{
    private $result;
    private $replacements;

    /**
     * @param string  $result
     * @param integer $replacements
     */
    public function __construct($result, $replacements)
    {
        $this->result = $result;
        $this->replacements = $replacements;
    }

    /**
     *
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     *
     */
    public function getReplacements()
    {
        return $this->replacements;
    }
}