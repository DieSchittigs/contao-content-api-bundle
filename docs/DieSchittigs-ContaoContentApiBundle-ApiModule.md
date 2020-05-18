DieSchittigs\ContaoContentApiBundle\ApiModule
===============

ApiModule augments ModuleModel for the API.




* Class name: ApiModule
* Namespace: DieSchittigs\ContaoContentApiBundle
* Parent class: [DieSchittigs\ContaoContentApiBundle\AugmentedContaoModel](DieSchittigs-ContaoContentApiBundle-AugmentedContaoModel.md)





Properties
----------


### $article

    public mixed $article





* Visibility: **public**


### $compiledHTML

    public mixed $compiledHTML





* Visibility: **public**


### $template

    public mixed $template





* Visibility: **public**


### $model

    public mixed $model = null





* Visibility: **public**


Methods
-------


### __construct

    mixed DieSchittigs\ContaoContentApiBundle\ApiModule::__construct(integer $id, $url)

constructor.



* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;id of the ModuleModel&lt;/p&gt;
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


