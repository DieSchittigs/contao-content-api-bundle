DieSchittigs\ContaoContentApiBundle\Article
===============

ApiContentElement augments ArticleModel for the API.




* Class name: Article
* Namespace: DieSchittigs\ContaoContentApiBundle
* Parent class: [DieSchittigs\ContaoContentApiBundle\AugmentedContaoModel](DieSchittigs-ContaoContentApiBundle-AugmentedContaoModel.md)





Properties
----------


### $content

    public mixed $content = array()





* Visibility: **public**


### $model

    public mixed $model = null





* Visibility: **public**


Methods
-------


### __construct

    mixed DieSchittigs\ContaoContentApiBundle\Article::__construct(integer $id, $url)

constructor.



* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;id of the ArticleModel&lt;/p&gt;
* $url **mixed**



### findByPageId

    mixed DieSchittigs\ContaoContentApiBundle\Article::findByPageId(integer $pid, $url)

Gets article by parent page id.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $pid **integer** - &lt;p&gt;id of the page&lt;/p&gt;
* $url **mixed**



### toJson

    mixed DieSchittigs\ContaoContentApiBundle\ContaoJsonSerializable::toJson()





* Visibility: **public**
* This method is defined by [DieSchittigs\ContaoContentApiBundle\ContaoJsonSerializable](DieSchittigs-ContaoContentApiBundle-ContaoJsonSerializable.md)




### __get

    mixed DieSchittigs\ContaoContentApiBundle\AugmentedContaoModel::__get(string $property)

Get the value from the attached model.



* Visibility: **public**
* This method is defined by [DieSchittigs\ContaoContentApiBundle\AugmentedContaoModel](DieSchittigs-ContaoContentApiBundle-AugmentedContaoModel.md)


#### Arguments
* $property **string** - &lt;p&gt;key&lt;/p&gt;


