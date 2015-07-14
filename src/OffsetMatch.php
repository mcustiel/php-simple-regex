<?php
namespace Mcustiel\PhpSimpleRegex;

class OffsetMatch extends AbstractMatch
{
    public function getOffset()
    {
        return empty($this->element) ? null : $this->element[1];
    }
}
