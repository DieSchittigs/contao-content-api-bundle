<?php

namespace DieSchittigs\ContaoContentApiBundle;

class FrontendModuleData {

    public $data;
    
    public function __toString()
    {
        return 'DieSchittigs\ContaoContentApiBundle\FrontendModuleData';
    }
		
	public function getFrontendModule($objRow, $strBuffer, \Contao\Module $objModule) : void
	{
		if ($this->data === null) {
            $this->data = $objModule->Template->getData();
            unset($this->data->Template);
            $this->data['moduleType'] = 'module';
		}
	}
}