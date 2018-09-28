Configuration
=============

[summary](/README.md)

## Default configuration

To use the default configuration, import the `@IadFilerTechBundle/Resources/config/config.yml` :

```yml
# app/config/config.yml

imports:
    - { resource: @IadFilerTechBundle/Resources/config/config.yml }
```

And add the `root_path` configuration:

```yml
# app/config/config.yml

iad_filer_tech:
    root_path: /Path/File/System
```

## Make your own configuration

You must configure [liip/LiipImagineBundle](http://symfony.com/doc/master/bundles/LiipImagineBundle/configuration.html)
and at least one [filter](http://symfony.com/doc/master/bundles/LiipImagineBundle/filters.html).

```yml
# app/config/config.yml

iad_filer_tech:
    root_path: /Path/File/System
    document_types: ARRAY OF SCALAR
    mime_types: ARRAY OF SCALAR
    image:
        default_filter: IMAGINE_FILTER_NAME
```
