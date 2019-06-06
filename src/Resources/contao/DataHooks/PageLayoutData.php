<?php

namespace DieSchittigs\ContaoContentApiBundle;

class PageLayoutData {

    public $data;
    
    public function __toString()
    {
        return 'DieSchittigs\ContaoContentApiBundle\PageLayoutData';
    }
		
	public function getPageLayout($objPage, \Contao\LayoutModel $objLayout, $pageObj) : void
	{
		if ($this->data === null) {
            $this->data = $objLayout->row();
		}
	}
}