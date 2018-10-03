Installation
============

[summary](/README.md)

## Require dependency

Require the **iad-holding/filer-tech-bundle** package in your `composer.json` and update your dependencies.

    $ composer require iad-holding/filer-tech-bundle

## Register bundle

Register the bundle in the `app/AppKernel.php`:

```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Iad\Bundle\FilerTechBundle\IadFilerTechBundle(),
    );
}
```

Check if all dependencies are registered:

```php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        //  [...]
        new Liip\ImagineBundle\LiipImagineBundle(),
        new Iad\Bundle\CoreBundle\IadCoreBundle(),

        // For the API
        // new FOS\RestBundle\FOSRestBundle(),

        // For the API Doc
        // new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
    );
}
```

## SQL Table

Create the table [filer.sql](https://github.com/IAD-HOLDING/IadDataRepo/blob/master/IadFilerTechBundle/v0.1/filer.sql)

## API

Add routing for the API in your `app/config/routing.yml`:

```yml
# app/config/routing.yml

iad_filer:
    type:     rest
    resource: "@IadFilerTechBundle/Resources/config/routing.yml"
    prefix:   /
```
