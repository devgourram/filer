<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business\Service;

use Gaufrette\Filesystem;
use Iad\Bundle\FilerTechBundle\Business\Service\AvatarFiler;
use Iad\Bundle\FilerTechBundle\Business\Encoder;
use Iad\Bundle\FilerTechBundle\Business\FileResource\File;
use Iad\Bundle\FilerTechBundle\Business\ImageManager;
use Iad\Bundle\FilerTechBundle\Business\Service\TrainingPolePictureFiler;
use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use Iad\Bundle\FilerTechBundle\Manager\AvatarManager;
use Iad\Bundle\FilerTechBundle\Manager\TrainingPolePictureManager;
use Liip\ImagineBundle\Binary\BinaryInterface;
use Liip\ImagineBundle\Model\Binary;

/**
 * Class TrainingPolePictureFilerTest
 *
 * @package Iad\Bundle\FilerTechBundle\Tests\Business\Service
 */
class TrainingPolePictureFilerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testAccessor()
    {
        $idPeople = 42;
        $filesystem = $this->getMockFilesystem();
        $trainingPolePictureFiler = $this->getTrainingPolePictureFiler($filesystem);
        $trainingPolePictureManager = $this->getMockTrainingPolepictureManager();

        $imageManager = $this
            ->getMockBuilder(ImageManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertSame($trainingPolePictureFiler, $trainingPolePictureFiler->setPublicFilesystem($filesystem));
        $this->assertEquals($filesystem, $trainingPolePictureFiler->getPublicFilesystem());
        $this->assertEquals($filesystem, $trainingPolePictureFiler->getFilesystem('public'));

        $this->assertSame($trainingPolePictureFiler, $trainingPolePictureFiler->setPrivateFilesystem($filesystem));
        $this->assertEquals($filesystem, $trainingPolePictureFiler->getPrivateFilesystem());
        $this->assertEquals($filesystem, $trainingPolePictureFiler->getFilesystem('private'));

        $this->assertSame($trainingPolePictureFiler, $trainingPolePictureFiler->setImageManager($imageManager));
        $this->assertEquals($imageManager, $trainingPolePictureFiler->getImageManager());

        $this->assertSame($trainingPolePictureFiler, $trainingPolePictureFiler->setTrainingPolePictureManager($trainingPolePictureManager));
        $this->assertEquals($trainingPolePictureManager, $trainingPolePictureFiler->getTrainingPolePictureManager());

        $file = $this
            ->getMockBuilder(File::class)
            ->disableOriginalConstructor()
            ->getMock();
        $file
            ->method('getAccess')
            ->willReturn('public');

        $this->assertInstanceOf(DocumentObject::class, $trainingPolePictureFiler->createDocumentObject($file, $idPeople));
    }

    /**
     * @param $filesystem
     *
     * @return TrainingPolePictureFiler
     */
    private function getTrainingPolePictureFiler($filesystem)
    {
        $encoder = new Encoder();

        $trainingPolePictureFiler = new TrainingPolePictureFiler($encoder);
        $trainingPolePictureFiler->setPublicFilesystem($filesystem);
        $trainingPolePictureFiler->setPrivateFilesystem($filesystem);


        return $trainingPolePictureFiler;
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
     * @return TrainingPolePictureManager
     */
    private function getMockTrainingPolepictureManager()
    {
        $trainingPolePictureManager = $this->getMockBuilder(TrainingPolePictureManager::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();

        return $trainingPolePictureManager;
    }
}
