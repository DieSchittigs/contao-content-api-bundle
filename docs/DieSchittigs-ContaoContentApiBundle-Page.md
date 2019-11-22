DieSchittigs\ContaoContentApiBundle\Page
===============

Page augments PageModel for the API.




* Class name: Page
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

    mixed DieSchittigs\ContaoContentApiBundle\Page::__construct(integer $id)

constructor.



* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;id of the PageModel&lt;/p&gt;



### findByUrl

    mixed DieSchittigs\ContaoContentApiBundle\Page::findByUrl($url, $exactMatch)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $url **mixed**
* $exactMatch **mixed**



### hasReader

    mixed DieSchittigs\ContaoContentApiBundle\Page::hasReader(string $readerType)

Does this Page have a reader module?



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


