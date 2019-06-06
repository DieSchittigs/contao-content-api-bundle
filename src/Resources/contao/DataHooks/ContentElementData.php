<?php

namespace DieSchittigs\ContaoContentApiBundle;

class ContentElementData {

    public $data = [];

    private $pid;
    
    public function __toString()
    {
        return 'DieSchittigs\ContaoContentApiBundle\ContentElementData';
    }
		
	public function getContentElement($objRow, $strBuffer, \Contao\ContentElement $objElement) : void
	{
        $Element['parsedContent'] = $strBuffer;
	}
}