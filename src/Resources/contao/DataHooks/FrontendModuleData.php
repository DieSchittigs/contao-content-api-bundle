<?php

namespace DieSchittigs\ContaoContentApiBundle;

class FrontendModuleData {

    public $data;
    
    public function __toString()
    {
        return 'DieSchittigs\ContaoContentApiBundle\FrontendModuleData';
    }
		
	public function getFrontendModule($objRow, $strBuffer, $objModule) : void
	{
		if ($this->data === null) {
            $this->data = $objRow->row();
            if($objModule instanceof \Contao\Module) {
                $this->data['modulType'] = 'module';
            } else {
                $this->data['modulType'] = 'article';
            }
		}
	}
}