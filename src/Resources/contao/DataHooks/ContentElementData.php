<?php

namespace DieSchittigs\ContaoContentApiBundle;

class ContentElementData {

    public $data = [];

    private $pid;
    
    public function __toString()
    {
        return 'DieSchittigs\ContaoContentApiBundle\ContentElementData';
    }
		
	public function getContentElement($objRow, $strBuffer, $objElement) : void
	{
        $strColumn = $objElement->Template->inColumn ?? 'main';
        if(empty($this->data[$strColumn])) {
            $this->data[$strColumn] = [];
        }
        
        if(empty($this->data[$strColumn][$objRow->pid])) {
            $this->data[$strColumn][$objRow->pid] = [];
        }

        $Element = $objRow->row();
        $Element['parsedContent'] = $strBuffer;
        $Element = Helper::toObj($Element, null, true);

        foreach($GLOBALS['TL_WRAPPERS'] as $type => $wrappers) {
            if(in_array($Element->type, $wrappers)) {
                $Element->isWrapper = $type;
                switch($type) {
                    case 'start':
                        $this->pid = [
                            'aid' => $objRow->pid,
                            'eid' => $Element->id
                        ];
                    break;
                    case 'end':
                        $this->pid = null;
                    break;
                }
            }
        }
        
        if($this->pid === null || $this->pid['eid'] === $Element->id) {
            $this->data[$strColumn][$objRow->pid][$Element->id] = $Element;
        } else {
            $this->data[$strColumn][$this->pid['aid']][$this->pid['eid']]->elements[$Element->id] = $Element;
        }
	}
}