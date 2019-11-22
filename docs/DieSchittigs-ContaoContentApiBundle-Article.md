DieSchittigs\ContaoContentApiBundle\Article
===============

ApiContentElement augments ArticleModel for the API.




* Class name: Article
* Namespace: DieSchittigs\ContaoContentApiBundle
* Parent class: [DieSchittigs\ContaoContentApiBundle\AugmentedContaoModel](DieSchittigs-ContaoContentApiBundle-AugmentedContaoModel.md)





Properties
----------


### $model

    public mixed $model = null





* Visibility: **public**


Methods
-------


### __construct

    mixed DieSchittigs\ContaoContentApiBundle\Article::__construct(integer $id)

constructor.



* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;id of the ArticleModel&lt;/p&gt;



### findByPageId

    mixed DieSchittigs\ContaoContentApiBundle\Article::findByPageId(integer $pid)

Gets article by parent page id.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $pid **integer** - &lt;p&gt;id of the page&lt;/p&gt;



### hasReader

    mixed DieSchittigs\ContaoContentApiBundle\Article::hasReader(string $readerType)

Does this Article have a reader module?



* Visibility: **public**


#### Arguments
* $readerType **string** - &lt;p&gt;What kind of reader? e.g. &#039;newsreader&#039;&lt;/p&gt;



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



### __set

    mixed DieSchittigs\ContaoContentApiBundle\AugmentedContaoModel::__set(string $property, mixed $value)

Set the value in the attached model.



* Visibility: **public**
* This method is defined by [DieSchittigs\ContaoContentApiBundle\AugmentedContaoModel](DieSchittigs-ContaoContentApiBundle-AugmentedContaoModel.md)


#### Arguments
* $property **string** - &lt;p&gt;key&lt;/p&gt;
* $value **mixed** - &lt;p&gt;value&lt;/p&gt;


