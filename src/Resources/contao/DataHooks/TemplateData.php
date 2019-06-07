<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\FormModel;

class TemplateData {

    public $data = [];

    private $wrapper = null;

    private $elements = [];

    private $article = null;
    
    public function __toString()
    {
        return 'DieSchittigs\ContaoContentApiBundle\TemplateData';
    }
    

    public function getContentElement($objRow, $strBuffer, $objElement)
    {
        $ElementModel = $objElement->getModel();

        if(empty($this->elements[$objElement->id]->type)) {
            $ElementData = $objRow->row();
            unset($ElementData['Template']);
            $this->elements[$objElement->id]->originalElement = $ElementData;
        }
        $this->elements[$objRow->id]->singleSRC = $ElementModel->singleSRC;
        $this->elements[$objRow->id]->multiSRC = $ElementModel->multiSRC;
        $this->elements[$objRow->id] = Helper::toObj($this->elements[$objRow->id], null, true);
        /** @see &$Element in self::parseTemplate */
        $this->elements[$objRow->id]->parsedContent = $strBuffer;
    }

	public function parseTemplate(\Contao\Template $template) : void
	{
        if(strpos($template->getName(), 'mod_article') === 0) {
            $this->article = $template->getData();
            unset($this->article['Template']);
        }
        if (preg_match('/ce_|form_/is', $template->getName())) {

            $PID = $template->pid ?? $this->article['id'];
            $strColumn = $template->inColumn ?? 'main';
            if(empty($this->data[$strColumn])) {
                $this->data[$strColumn] = [];
            }
            
            if(empty($this->data[$strColumn][$PID])) {
                $this->data[$strColumn][$PID] = [];
            }

            $Element = $template->getData();
            
            unset($Element['Template']);
            $Element = Helper::toObj($Element, null, true);

            $this->elements[$Element->id] = &$Element;

            foreach($GLOBALS['TL_WRAPPERS'] as $type => $wrappers) {
                if(in_array($Element->type, $wrappers)) {
                    $Element->isWrapper = $type;
                    switch($type) {
                        case 'start':
                            $this->wrapper = [
                                'aid' => $PID,
                                'eid' => $Element->id,
                                'block' => 0
                            ];
                        break;
                        case 'separator':
                            $this->wrapper['block']++;
                        break;
                        case 'stop':
                            $this->wrapper = null;
                        break;
                    }
                }
            }
            
            if($this->wrapper === null || $this->wrapper['eid'] === $Element->id) {
                $this->data[$strColumn][$PID][$Element->id] = $Element;
            } else {
                $this->data[$strColumn][$this->wrapper['aid']][$this->wrapper['eid']]->elements[($this->wrapper['block']??0)][$Element->id] = $Element;
            }
		}
	}
}