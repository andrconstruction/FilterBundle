#Symfony2/Symfony3 Filter Bundle

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
