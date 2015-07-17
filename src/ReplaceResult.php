<?php
namespace Mcustiel\PhpSimpleRegex;

/**
 * Represents the result of calling a preg_replace_* function and requesting the count of replacements.
 *
 * @author mcustiel
 * @codeCoverageIgnore
 */
class ReplaceResult
{
    /**
     * @var string
     */
    private $result;
    /**
     * @var integer
     */
    private $replacements;

    /**
     * Class constructor.
     *
     * @param string $result
     * @param integer $replacements
     */
    public function __construct($result, $replacements)
    {
        $this->result = $result;
        $this->replacements = $replacements;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return number
     */
    public function getReplacements()
    {
        return $this->replacements;
    }
}
