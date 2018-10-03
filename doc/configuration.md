Configuration
=============

[summary](/README.md)


Installation
------------

Installation is a quick (I promise!) 7 step process:

1. Download IadFilerTechBundle using composer
2. Enable the Bundle
3. Create your Picture class
4. Configure the IadFilerTechBundle
5. Update your database schema

Step 1: Download IadFilerTechBundle using composer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Require the bundle with composer:

.. code-block:: bash

    $ composer require friendsofsymfony/user-bundle "~2.0"
    
Composer will install the bundle to your project's ``vendor/friendsofsymfony/user-bundle`` directory.
If you encounter installation errors pointing at a lack of configuration parameters, such as ``The child node "db_driver" at path "fos_user" must be configured``, you should complete the configuration in Step 5 first and then re-run this step.

Step 2: Enable the bundle
~~~~~~~~~~~~~~~~~~~~~~~~~