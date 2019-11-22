DieSchittigs\ContaoContentApiBundle\File
===============

File augments FilesModel for the API.




* Class name: File
* Namespace: DieSchittigs\ContaoContentApiBundle
* Parent class: [DieSchittigs\ContaoContentApiBundle\AugmentedContaoModel](DieSchittigs-ContaoContentApiBundle-AugmentedContaoModel.md)





Properties
----------


### $fileObj

    private mixed $fileObj = array('id', 'uuid', 'name', 'extension', 'singleSRC', 'meta', 'size', 'filesModel')





* Visibility: **private**
* This property is **static**.


### $model

    public mixed $model = null





* Visibility: **public**


Methods
-------


### __construct

    mixed DieSchittigs\ContaoContentApiBundle\File::__construct(string $uuid, mixed $size)

constructor.



* Visibility: **public**


#### Arguments
* $uuid **string** - &lt;p&gt;uuid of the FilesModel&lt;/p&gt;
* $size **mixed** - &lt;p&gt;Object or serialized string representing the (image) size&lt;/p&gt;



### children

    mixed DieSchittigs\ContaoContentApiBundle\File::children(string $uuid, integer $depth)

Recursively load file (directory) children.



* Visibility: **private**
* This method is **static**.


#### Arguments
* $uuid **string** - &lt;p&gt;uuid of the FilesModel&lt;/p&gt;
* $depth **integer** - &lt;p&gt;How deep do you want to fetch children?&lt;/p&gt;



### get

    mixed DieSchittigs\ContaoContentApiBundle\File::get(string $path, integer $depth)

Recursively load file by path.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $path **string** - &lt;p&gt;Path of the FilesModel&lt;/p&gt;
* $depth **integer** - &lt;p&gt;How deep do you want to fetch children?&lt;/p&gt;



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


