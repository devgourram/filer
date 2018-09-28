Usage
=====

[summary](/README.md)

 - [Save](usage.md#save-a-document)
 - [Get metadata](usage.md#get-metadata)
 - [Get Document](usage.md#get-document-and-metadata)

## Save a document

### Load the file

#### Load from File upload

```php
/**
 * var \Symfony\Component\HttpFoundation\File\UploadedFile $fileUpload
 */

$filer = $this->get('iad_filer');
$fileBuilder = $this->get('iad_filer.builder');

$file = $fileBuilder->getFromFileUpload(
    $fileUpload,
    $type,
    $access,
    $details
);
```

#### Load from Data

```php
$file = $fileBuilder->getFromData(
    $data,
    $name
    $type,
    $access,
    $details
);
```

#### Load from Gaufrette File

```php
/**
 * var \Gaufrette\File       $fileGaufrette
 * var \Gaufrette\FileSystem $fileSystem
 */

$file = $fileBuilder->getFromFileGaufrette(
    $fileGaufrette,
    $fileSystem
    $type,
    $access,
    $details
);
```

### Save the file

```php
$filer = $this->get('iad_filer');

$responseFiler = $filer->save($file);
```

## Get Metadata

```php
$filer = $this->get('iad_filer');

$metadata = $filer->getMetaData($uuid);
```

## Get Document and Metadata

Data is base64 encoded.

```php
$filer = $this->get('iad_filer');

$document = $filer->get($uuid);
```