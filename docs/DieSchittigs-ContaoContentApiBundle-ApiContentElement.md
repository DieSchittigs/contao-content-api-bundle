DieSchittigs\ContaoContentApiBundle\ApiContentElement
===============

ApiContentElement augments ContentModel for the API.




* Class name: ApiContentElement
* Namespace: DieSchittigs\ContaoContentApiBundle
* Parent class: [DieSchittigs\ContaoContentApiBundle\AugmentedContaoModel](DieSchittigs-ContaoContentApiBundle-AugmentedContaoModel.md)





Properties
----------


### $content

    public mixed $content = array()





* Visibility: **public**


### $module

    public mixed $module





* Visibility: **public**


### $form

    public mixed $form





* Visibility: **public**


### $model

    public mixed $model = null





* Visibility: **public**


Methods
-------


### __construct

    mixed DieSchittigs\ContaoContentApiBundle\ApiContentElement::__construct(integer $id, string $inColumn, $url)

constructor.



* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;id of the ContentModel&lt;/p&gt;
* $inColumn **string** - &lt;p&gt;In which column does the Content Element reside in&lt;/p&gt;
* $url **mixed**



### findByPidAndTable

    mixed DieSchittigs\ContaoContentApiBundle\ApiContentElement::findByPidAndTable(integer $pid, string $table, string $inColumn, $url)

Select by Parent ID and Table.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $pid **integer** - &lt;p&gt;Parent ID&lt;/p&gt;
* $table **string** - &lt;p&gt;Parent table&lt;/p&gt;
* $inColumn **string** - &lt;p&gt;In which column doe the Content Elements reside in&lt;/p&gt;
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


