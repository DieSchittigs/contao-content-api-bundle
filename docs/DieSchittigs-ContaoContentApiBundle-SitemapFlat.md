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

    mixed DieSchittigs\ContaoContentApiBundle\SitemapFlat::__construct(\DieSchittigs\ContaoContentApiBundle\string $language)





* Visibility: **public**


#### Arguments
* $language **DieSchittigs\ContaoContentApiBundle\string**



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



