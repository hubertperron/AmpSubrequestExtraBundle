AmpPDFCrowdBundle
=================

This bundle add a way to graphically view each subrequests used on a single page. Subrequests are wrapped in a template container displaying additional information about the request.

## Installation

### Using composer

    {
        "require": {                                             |
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

## Configuration

TODO

``` yaml
amp_subrequest_extra:
    ~
```

## Usage

Use the web debug toolbar icon to toggle the subrequests wrapper.