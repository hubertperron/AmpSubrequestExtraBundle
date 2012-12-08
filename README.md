AmpSubrequestExtraBundle
=================

This bundle add a way to graphically view each subrequests used on a single page. Subrequests are wrapped in a template container displaying additional information about the request.

## Installation

### Using the deps file

    [AmpSubrequestExtraBundle]
        git=http://github.com/hubertperron/AmpSubrequestExtraBundle.git
        target=/bundles/Amp/SubrequestExtraBundle

### Using composer

    {
        "require": {
            "amp/subrequestextra-bundle": "dev-master"
        }
    }

### Add the bundle to your application kernel

``` php
// File: app/AppKernel.php
public function registerBundles()
{
    if (in_array($this->getEnvironment(), array('dev', 'test'))) {
        // ...
        new Amp\SubrequestExtraBundle\AmpSubrequestExtraBundle();
    );
}
```

### Register namespace (Symfony 2.0.x)

``` php
// File: app/autoload.php
$loader->registerNamespaces(array(
        // ...
        'Amp' => __DIR__.'/../vendor/bundles',
));
```

## Configuration

``` yaml
amp_subrequest_extra:
    ignore_controllers:
        - AcmeDemoBundle:Welcome:index
        - AcmeDemoBundle:Example:list
```

## Usage

Use the web debug toolbar icon to toggle the subrequests wrapper.

## Example

Without using parameters.

``` twig
{% render 'EgzaktFrontendHomeBundle:Home:ExampleWithoutParameters' %}
```

![without parameters](http://raw.github.com/hubertperron/AmpSubrequestExtraBundle/master/Resources/doc/without_parameters.png)

Using parameters.

``` twig
{% render 'EgzaktFrontendHomeBundle:Home:ExampleWithParameters' with { id: 1, hash: '0a7254fc5', displayActive: true } %}
```

![with parameters](http://raw.github.com/hubertperron/AmpSubrequestExtraBundle/master/Resources/doc/with_parameters.png)

Returning an empty response.

``` twig
{% render 'EgzaktFrontendHomeBundle:Home:ExampleReturningEmptyResponse' %}
```

![empty response](https://raw.github.com/hubertperron/AmpSubrequestExtraBundle/master/Resources/doc/empty_response.png)


