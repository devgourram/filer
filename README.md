IadFilerTechBundle
==================

[![Build Status](http://jenkins.iadholding.com/buildStatus/icon?job=FilerBundle)](http://jenkins.iadholding.com/job/FilerBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/97cf7664-3135-4271-909e-860272e2ab6f/mini.png)](https://insight.sensiolabs.com/projects/97cf7664-3135-4271-909e-860272e2ab6f)

FilerTechBundle is a technical bundle providing a simple way to store files and a single REST API to get files according to users rights.

This bundle require:

 - [liip/LiipImagineBundle](https://github.com/liip/LiipImagineBundle)
 - [KnpLabs/Gaufrette](https://github.com/KnpLabs/Gaufrette)
 - [FriendsOfSymfony/FOSRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle) (optional for the REST API)
 - [nelmio/NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle) (optional for the API Doc)

## Summary

 - [Installation](doc/installation.md)
 - [Configuration](doc/configuration.md)
 - [Tests](doc/test.md)
 - [Usage](/doc/usage.md)
 - [Filer API](/doc/filer.md)

## Service Filer

Service Id : `iad_filer`

### Adapters

 - Gaufrette (https://github.com/KnpLabs/Gaufrette)
 - LiipImagine (https://github.com/liip/LiipImagineBundle)
