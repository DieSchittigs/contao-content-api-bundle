DieSchittigs\ContaoContentApiBundle\Sitemap
===============

Sitemap represents the actual site structure as an object tree.

The resulting instance can be iterated and used like an array.


* Class name: Sitemap
* Namespace: DieSchittigs\ContaoContentApiBundle
* This class implements: IteratorAggregate, ArrayAccess, Countable, [DieSchittigs\ContaoContentApiBundle\ContaoJsonSerializable](DieSchittigs-ContaoContentApiBundle-ContaoJsonSerializable.md)




Properties
----------


### $sitemap

    protected mixed $sitemap = array()





* Visibility: **protected**


### $sitemapFlat

    public mixed $sitemapFlat





* Visibility: **public**


Methods
-------


### __construct

    mixed DieSchittigs\ContaoContentApiBundle\Sitemap::__construct(string $language, integer $pid)

constructor.



* Visibility: **public**


#### Arguments
* $language **string** - &lt;p&gt;If set, ignores other languages&lt;/p&gt;
* $pid **integer** - &lt;p&gt;Parent ID (for recursive calls)&lt;/p&gt;



### getIterator

    mixed DieSchittigs\ContaoContentApiBundle\Sitemap::getIterator()





* Visibility: **public**




### offsetExists

    mixed DieSchittigs\ContaoContentApiBundle\Sitemap::offsetExists($offset)





* Visibility: **public**


#### Arguments
* $offset **mixed**



### offsetGet

    mixed DieSchittigs\ContaoContentApiBundle\Sitemap::offsetGet($offset)





* Visibility: **public**


#### Arguments
* $offset **mixed**



### offsetSet

    mixed DieSchittigs\ContaoContentApiBundle\Sitemap::offsetSet($offset, $value)





* Visibility: **public**


#### Arguments
* $offset **mixed**
* $value **mixed**



### offsetUnset

    mixed DieSchittigs\ContaoContentApiBundle\Sitemap::offsetUnset($offset)





* Visibility: **public**


#### Arguments
* $offset **mixed**



### count

    mixed DieSchittigs\ContaoContentApiBundle\Sitemap::count()





* Visibility: **public**




### toJson

    mixed DieSchittigs\ContaoContentApiBundle\ContaoJsonSerializable::toJson()





* Visibility: **public**
* This method is defined by [DieSchittigs\ContaoContentApiBundle\ContaoJsonSerializable](DieSchittigs-ContaoContentApiBundle-ContaoJsonSerializable.md)



