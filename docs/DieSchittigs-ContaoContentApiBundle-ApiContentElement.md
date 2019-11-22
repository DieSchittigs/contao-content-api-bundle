DieSchittigs\ContaoContentApiBundle\ApiContentElement
===============

ApiContentElement augments ContentModel for the API.




* Class name: ApiContentElement
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

    mixed DieSchittigs\ContaoContentApiBundle\ApiContentElement::__construct(integer $id, string $inColumn)

constructor.



* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;id of the ContentModel&lt;/p&gt;
* $inColumn **string** - &lt;p&gt;In which column does the Content Element reside in&lt;/p&gt;



### findByPidAndTable

    mixed DieSchittigs\ContaoContentApiBundle\ApiContentElement::findByPidAndTable(integer $pid, string $table, string $inColumn)

Select by Parent ID and Table.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $pid **integer** - &lt;p&gt;Parent ID&lt;/p&gt;
* $table **string** - &lt;p&gt;Parent table&lt;/p&gt;
* $inColumn **string** - &lt;p&gt;In which column doe the Content Elements reside in&lt;/p&gt;



### hasReader

    mixed DieSchittigs\ContaoContentApiBundle\ApiContentElement::hasReader(string $readerType)

Does this Content Element have a reader module?



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


