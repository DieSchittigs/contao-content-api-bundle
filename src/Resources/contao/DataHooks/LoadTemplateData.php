<?php

namespace DieSchittigs\ContaoContentApiBundle;

class LoadTemplateData {

    public $data;
    
    public function __toString()
    {
        return 'DieSchittigs\ContaoContentApiBundle\LoadTemplateData';
    }
		
	public function onParseTemplate(\Contao\Template $template) : void
	{
		if ($this->data === null && strpos($template->getName(), 'ce_') === 0) {
            $this->data = $template->getData();
            foreach($GLOBALS['TL_WRAPPERS'] as $type => $wrappers) {
                if(in_array($this->data['type'], $wrappers)) {
                    $this->data['wrapperElement'] = [
                        'type' => $type
                    ];
                }
            }
		}
	}
}