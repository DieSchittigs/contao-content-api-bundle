DieSchittigs\ContaoContentApiBundle\SitemapFlat
===============

SitemapFlat represents the actual site structure as a key value object.

Key: URL of the page
Value: PageModel.


* Class name: SitemapFlat
* Namespace: DieSchittigs\ContaoContentApiBundle
* This class implements: [DieSchittigs\ContaoContentApiBundle\ContaoJsonSerializable](DieSchittigs-ContaoContentApiBundle-ContaoJsonSerializable.md)




Properties
----------


### $sitemap

    public mixed $sitemap





* Visibility: **public**


Methods
-------


### __construct

    mixed DieSchittigs\ContaoContentApiBundle\SitemapFlat::__construct(string $language)

constructor.



* Visibility: **public**


#### Arguments
* $language **string** - &lt;p&gt;If set, ignores other languages&lt;/p&gt;



### findUrl

    mixed DieSchittigs\ContaoContentApiBundle\SitemapFlat::findUrl($url, $exactMatch)





* Visibility: **public**


#### Arguments
* $url **mixed**
* $exactMatch **mixed**



### toJson

    mixed DieSchittigs\ContaoContentApiBundle\ContaoJsonSerializable::toJson()





* Visibility: **public**
* This method is defined by [DieSchittigs\ContaoContentApiBundle\ContaoJsonSerializable](DieSchittigs-ContaoContentApiBundle-ContaoJsonSerializable.md)



