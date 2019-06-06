<?php

namespace DieSchittigs\ContaoContentApiBundle;

class TemplateData {

    public $data = [];

    private $pid;

    private $elements = [];
    
    public function __toString()
    {
        return 'DieSchittigs\ContaoContentApiBundle\TemplateData';
    }

    public function getContentElement($objRow, $strBuffer, $objElement)
    {
        $this->elements[$objRow->id]->parsedContent = $strBuffer;
    }
		
	public function parseTemplate(\Contao\Template $template) : void
	{
        if (strpos($template->getName(), 'ce_') === 0) {
            $strColumn = $template->inColumn ?? 'main';
            if(empty($this->data[$strColumn])) {
                $this->data[$strColumn] = [];
            }
            
            if(empty($this->data[$strColumn][$template->pid])) {
                $this->data[$strColumn][$template->pid] = [];
            }

            $Element = $template->getData();
            
            unset($Element['Template']);
            // $Element['parsedContent'] = $template->parse();
            $Element = Helper::toObj($Element, null, true);

            $this->elements[$Element->id] = &$Element;

            foreach($GLOBALS['TL_WRAPPERS'] as $type => $wrappers) {
                if(in_array($Element->type, $wrappers)) {
                    $Element->isWrapper = $type;
                    switch($type) {
                        case 'start':
                            $this->pid = [
                                'aid' => $template->pid,
                                'eid' => $Element->id,
                                'block' => 0
                            ];
                        break;
                        case 'separator':
                            $this->pid['block']++;
                        break;
                        case 'end':
                            $this->pid = null;
                        break;
                    }
                }
            }
            
            if($this->pid === null || $this->pid['eid'] === $Element->id) {
                $this->data[$strColumn][$template->pid][$Element->id] = $Element;
            } else {
                $this->data[$strColumn][$this->pid['aid']][$this->pid['eid']]->elements[$this->pid['block']][$Element->id] = $Element;
            }
		}
	}
}