<?php

namespace DieSchittigs\ContaoContentApiBundle;

class PageData {

    public $data;
    
    public function __toString()
    {
        return 'DieSchittigs\ContaoContentApiBundle\PageData';
    }
		
	public function generatePage($objPage, $objLayout, $api) : void
	{
        if($this->data === null) {
            $this->data = $objPage->row();
        }
	}
}