DieSchittigs\ContaoContentApiBundle\ContaoJson
===============

ContaoJson tries to pack &quot;everyting Contao&quot; into a JSON-serializable package.

It works with:
 - Contao Collections
 - Contao Models
 - Arrays (of Models or anything else)
 - Objects
 - Strings and numbers
The main features are
 - File objects (e.g. singleSRC) are resolved automatically
 - Serialized arrays are resolved automatically
 - HTML will be unescaped automatically
 - Contao Insert-Tags are resolved automatically
ContaoJson will recursively call itself until all fields are resolved.


* Class name: ContaoJson
* Namespace: DieSchittigs\ContaoContentApiBundle
* This class implements: JsonSerializable




Properties
----------


### $data

    public mixed $data = null





* Visibility: **public**


### $allowedFields

    private mixed $allowedFields





* Visibility: **private**


Methods
-------


### __construct

    mixed DieSchittigs\ContaoContentApiBundle\ContaoJson::__construct($data, array $allowedFields)





* Visibility: **public**


#### Arguments
* $data **mixed**
* $allowedFields **array**



### handleCollection

    mixed DieSchittigs\ContaoContentApiBundle\ContaoJson::handleCollection(\Contao\Model\Collection $collection)





* Visibility: **private**


#### Arguments
* $collection **Contao\Model\Collection**



### handleArray

    mixed DieSchittigs\ContaoContentApiBundle\ContaoJson::handleArray(array $array)





* Visibility: **private**


#### Arguments
* $array **array**



### handleObject

    mixed DieSchittigs\ContaoContentApiBundle\ContaoJson::handleObject(\DieSchittigs\ContaoContentApiBundle\object $object)





* Visibility: **private**


#### Arguments
* $object **DieSchittigs\ContaoContentApiBundle\object**



### handleNumber

    mixed DieSchittigs\ContaoContentApiBundle\ContaoJson::handleNumber($number)





* Visibility: **private**


#### Arguments
* $number **mixed**



### handleString

    mixed DieSchittigs\ContaoContentApiBundle\ContaoJson::handleString(\DieSchittigs\ContaoContentApiBundle\string $string)





* Visibility: **private**


#### Arguments
* $string **DieSchittigs\ContaoContentApiBundle\string**



### isAssoc

    mixed DieSchittigs\ContaoContentApiBundle\ContaoJson::isAssoc(array $arr)





* Visibility: **private**


#### Arguments
* $arr **array**



### unserialize

    mixed DieSchittigs\ContaoContentApiBundle\ContaoJson::unserialize(\DieSchittigs\ContaoContentApiBundle\string $string)





* Visibility: **private**


#### Arguments
* $string **DieSchittigs\ContaoContentApiBundle\string**



### jsonSerialize

    mixed DieSchittigs\ContaoContentApiBundle\ContaoJson::jsonSerialize()





* Visibility: **public**



