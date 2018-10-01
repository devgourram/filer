<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business\Service;

use Gaufrette\Filesystem;
use Iad\Bundle\FilerTechBundle\Business\Service\AvatarFiler;
use Iad\Bundle\FilerTechBundle\Business\Encoder;
use Iad\Bundle\FilerTechBundle\Business\FileResource\File;
use Iad\Bundle\FilerTechBundle\Business\ImageManager;
use Iad\Bundle\FilerTechBundle\Business\Service\RealEstatePictureFiler;
use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use Iad\Bundle\FilerTechBundle\Manager\AvatarManager;
use Iad\Bundle\FilerTechBundle\Manager\RealEstatePictureManager;
use Liip\ImagineBundle\Binary\BinaryInterface;
use Liip\ImagineBundle\Model\Binary;

/**
 * Class AvatarFilerTest
 *
 * @package Iad\Bundle\FilerTechBundle\Tests\Business
 */
class RealEstatePictureFilerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testAccessor()
    {
        $idPeople = 42;
        $filesystem               = $this->getMockFilesystem();
        $realestatePictureFiler   = $this->getRealEstatePictureFiler($filesystem);
        $realEstatePictureManager = $this->getMockRealEstatepictureManager();

        $imageManager = $this
            ->getMockBuilder(ImageManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertSame($realestatePictureFiler, $realestatePictureFiler->setPublicFilesystem($filesystem));
        $this->assertEquals($filesystem, $realestatePictureFiler->getPublicFilesystem());
        $this->assertEquals($filesystem, $realestatePictureFiler->getFilesystem('public'));

        $this->assertSame($realestatePictureFiler, $realestatePictureFiler->setPrivateFilesystem($filesystem));
        $this->assertEquals($filesystem, $realestatePictureFiler->getPrivateFilesystem());
        $this->assertEquals($filesystem, $realestatePictureFiler->getFilesystem('private'));

        $this->assertSame($realestatePictureFiler, $realestatePictureFiler->setImageManager($imageManager));
        $this->assertEquals($imageManager, $realestatePictureFiler->getImageManager());

        $this->assertSame($realestatePictureFiler, $realestatePictureFiler->setRealEstatePictureManager($realEstatePictureManager));
        $this->assertEquals($realEstatePictureManager, $realestatePictureFiler->getRealEstatePictureManager());

        $file = $this
            ->getMockBuilder(File::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $file
            ->method('getAccess')
            ->willReturn('public')
            ;

        $this->assertInstanceOf(DocumentObject::class, $realestatePictureFiler->createDocumentObject($file, $idPeople));
    }

    /**
     * @param $filesystem
     *
     * @return RealEstatePictureFiler
     */
    private function getRealEstatePictureFiler($filesystem)
    {
        $encoder = new Encoder();

        $realestatePictureFiler = new RealEstatePictureFiler($encoder);
        $realestatePictureFiler->setPublicFilesystem($filesystem);
        $realestatePictureFiler->setPrivateFilesystem($filesystem);


        return $realestatePictureFiler;
    }

    /**
     * @return Filesystem
     */
    private function getMockFilesystem()
    {
        $filesystem = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->setMethods(['write', 'size'])
            ->getMock();
        $filesystem
            ->method('size')
            ->willReturn(42);
        $filesystem
            ->method('write')
            ->willReturn(42);

        return $filesystem;
    }

    /**
     * @return RealEstatePictureManager
     */
    private function getMockRealEstatepictureManager()
    {
        $realEstatePictureManager = $this->getMockBuilder(RealEstatePictureManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $realEstatePictureManager;
    }
}
