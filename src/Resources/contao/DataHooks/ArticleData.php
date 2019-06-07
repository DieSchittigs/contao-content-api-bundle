<?php

namespace DieSchittigs\ContaoContentApiBundle;

class ArticleData {

    public $data = [];

    private $name = 'ArticleData';
    
    public function __toString()
    {
        return 'DieSchittigs\ContaoContentApiBundle\\' . $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
		
	public function getArticle($objRow) : void
	{
        if(empty($this->data[$objRow->inColumn])) {
            $this->data[$objRow->inColumn] = [];
        }
        $this->data[$objRow->inColumn][$objRow->id] = $objRow->row();
        $this->data[$objRow->inColumn][$objRow->id]['moduleType'] = 'article';
    }
    
    public function __destruct()
    {
        $this->data = null;
    }
}