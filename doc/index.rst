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

    $ composer require iad-holding/filer-tech-bundle "master"

Step 2: Enable the bundle
~~~~~~~~~~~~~~~~~~~~~~~~~


Enable the bundle in the kernel::

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Iad\Bundle\CoreBundle\IadCoreBundle(),

            // For the API
            // new FOS\RestBundle\FOSRestBundle(),

            // For the API Doc
            // new Nelmio\ApiDocBundle\NelmioApiDocBundle(),

            new Iad\Bundle\FilerTechBundle\IadFilerTechBundle(),
            // ...
        );
    }

Step 3: Create your Picture class
~~~~~~~~~~~~~~~~~~~~~~~~~

Create Picture & PictureFile class

.. configuration-block::

    .. code-block:: php-annotations

        <?php
        // src/AppBundle/Entity/Picture.php

        namespace AppBundle\Entity;

        use Iad\Bundle\FilerTechBundle\Model\Picture as BasePicture;
        use Doctrine\ORM\Mapping as ORM;

        /**
         * @ORM\Entity
         * @ORM\Table(name="app_pictures")
         */
        class Picture extends BasePicture
        {
            /**
             * @ORM\Id
             * @ORM\Column(type="integer")
             * @ORM\GeneratedValue(strategy="AUTO")
             */
            protected $id;

        }

    .. code-block:: php-annotations

        <?php
        // src/AppBundle/Entity/PictureFile.php

        namespace AppBundle\Entity;

        use Iad\Bundle\FilerTechBundle\Model\PictureFile as BasePictureFile;
        use Doctrine\ORM\Mapping as ORM;

        /**
         * @ORM\Entity
         * @ORM\Table(name="app_pictures_file")
         */
        class PictureFile extends BasePictureFile
        {
            /**
             * @ORM\Id
             * @ORM\Column(type="integer")
             * @ORM\GeneratedValue(strategy="AUTO")
             */
            protected $id;

            /**
             * @var Picture $picture
             * @ORM\ManyToOne(targetEntity="Picture", inversedBy="files")
             * @ORM\JoinColumn(name="id_picture", referencedColumnName="id", nullable=false, onDelete="cascade")
             */
            protected $picture;

        }


Step 4: Configure the IadFilerTechBundle
~~~~~~~~~~~~~~~~~~~~~~~~~
.. configuration-block::

    .. code-block:: yaml

        # app/config/config.yml
        iad_filer_tech:
            picture_filer:
                channel: local
                public_base_url: "%picture_filer.base_url%"
                resizing_filters: ['small', 'tiny']
                class_file: AppBundle\Entity\PictureFile
                class: AppBundle\Entity\Picture
                directory_prefix: 'pictures/'
                document_type: 'picture'
