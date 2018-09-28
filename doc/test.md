Tests
=====

[summary](/README.md)

## Unit test

Run test:

    $ phpunit

## Upload test

### Configuration

To use the upload test route, add the resource in your `app/config/routing_dev.yml`:

```yml
# app/config/routing_dev.yml
iad_filer_test:
    type:
    resource: "@IadFilerTechBundle/Resources/config/routing_test.yml"
    prefix:   /
```

The default route is: /documents/
