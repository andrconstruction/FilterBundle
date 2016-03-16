#Symfony2/Symfony3 Filter Bundle

[![Build Status](https://img.shields.io/scrutinizer/build/g/Bukashk0zzz/FilterBundle.svg?style=flat-square)](https://travis-ci.org/Bukashk0zzz/FilterBundle)
[![Code Coverage](https://img.shields.io/codecov/c/github/Bukashk0zzz/FilterBundle.svg?style=flat-square)](https://codecov.io/github/Bukashk0zzz/FilterBundle)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/Bukashk0zzz/FilterBundle.svg?style=flat-square)](https://scrutinizer-ci.com/g/Bukashk0zzz/FilterBundle/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/56e91ff84e714c0035e76109/badge.svg?style=flat)](https://www.versioneye.com/user/projects/56e91ff84e714c0035e76109)
[![License](https://img.shields.io/packagist/l/Bukashk0zzz/filter-bundle.svg?style=flat-square)](https://packagist.org/packages/Bukashk0zzz/filter-bundle)
[![Latest Stable Version](https://img.shields.io/packagist/v/Bukashk0zzz/filter-bundle.svg?style=flat-square)](https://packagist.org/packages/Bukashk0zzz/filter-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/Bukashk0zzz/filter-bundle.svg?style=flat-square)](https://packagist.org/packages/Bukashk0zzz/filter-bundle)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/64a668ef-4f7c-4e53-89f9-a31aff7c315c/small.png)](https://insight.sensiolabs.com/projects/64a668ef-4f7c-4e53-89f9-a31aff7c315c)
[![knpbundles.com](http://knpbundles.com/Bukashk0zzz/FilterBundle/badge-short)](http://knpbundles.com/Bukashk0zzz/FilterBundle)

About
-----
This bundle add a service that can be used to filter object values based on annotations. [ZendFilters](https://github.com/zendframework/zend-filter) used for filtering.
Also bundle can filter your forms if it finds a annotated entity attached. If `auto_filter_forms` enabled entities will be filtered before they are validated.
[Zend filters doc](http://framework.zend.com/manual/current/en/modules/zend.filter.set.html)

Installation
------------

Add this to your `composer.json` file:

```json
"require": {
	"bukashk0zzz/filter-bundle": "dev-master",
}
```


Add the bundle to `app/AppKernel.php`

```php
$bundles = array(
	// ... other bundles
	new Bukashk0zzz\FilterBundle\Bukashk0zzzFilterBundle(),
);
```

Configuration
-------------

Add this to your `config.yml`:

```yaml
bukashk0zzz_filter:
    # Enable if you need auto filtering form data before constrain(Validation) check
    auto_filter_forms: false
```

Usage
------

Bundle provides one annotation which allow filter fields in your entities.

Add the next class to the `use` section of your entity class.

```php
use Bukashk0zzz\FilterBundle\Annotation\FilterAnnotation as Filter;
```

Annotation `@Filter` has one required option *filter* which value should be name of Zend filter class.
It can be set like this `@Filter("StringTrim")` or `@@Filter(filter="StringTrim")`. 

Also there is one not required option `options` - it must be array type and will pass to Zend filter using `setOptions` method from zend filter. 

Example entity
--------------

```php
<?php
namespace AppBundle\Entity;

use Bukashk0zzz\FilterBundle\Annotation\FilterAnnotation as Filter;

/**
 * User Entity
 */
class User
{
    /**
     * @Filter("StripTags", options={"allowTags": "br"})
     * @Filter("StringTrim")
     * @Filter("StripNewlines")
     * @var string
     */
    protected $name;

    /**
     * @Filter("StripTags")
     * @Filter("StringTrim")
     * @var string
     */
    protected $about;
}

```

Using filter service
--------------------

Use the `bukashk0zzz_filter.filter` service along with annotations in the Entity to filter data.

```php
public function indexAction()
{

    $entity = new \Acme\DemoBundle\Entity\SampleEntity();
    $entity->name = "My <b>name</b>";
    $entity->email = " email@mail.com";

    $filterService = $this->get('bukashk0zzz_filter.filter');
    $filterService->filterEntity($entity);

    return ['entity' => $entity];
}
```

Copyright / License
-------------------

See [LICENSE](https://github.com/bukashk0zzz/FilterBundle/blob/master/LICENSE)
