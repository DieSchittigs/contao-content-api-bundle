DieSchittigs\ContaoContentApiBundle\Page
===============

Page augments PageModel for the API.




* Class name: Page
* Namespace: DieSchittigs\ContaoContentApiBundle
* Parent class: [DieSchittigs\ContaoContentApiBundle\AugmentedContaoModel](DieSchittigs-ContaoContentApiBundle-AugmentedContaoModel.md)





Properties
----------


### $url

    public mixed $url





* Visibility: **public**


### $urlAbsolute

    public mixed $urlAbsolute





* Visibility: **public**


### $articles

    public mixed $articles





* Visibility: **public**


### $layout

    public mixed $layout





* Visibility: **public**


### $model

    public mixed $model = null





* Visibility: **public**


Methods
-------


### __construct

    mixed DieSchittigs\ContaoContentApiBundle\Page::__construct(integer $id, $url)

constructor.



* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;id of the PageModel&lt;/p&gt;
* $url **mixed**



### findByUrl

    mixed DieSchittigs\ContaoContentApiBundle\Page::findByUrl($url, $exactMatch)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $url **mixed**
* $exactMatch **mixed**



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


