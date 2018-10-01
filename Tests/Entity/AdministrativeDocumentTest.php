<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Iad\Bundle\FilerTechBundle\Entity\AdministrativeDocument;
use Iad\Bundle\FilerTechBundle\Entity\RealEstatePicture;
use Iad\Bundle\FilerTechBundle\Entity\RealEstatePictureFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class AdministrativeDocumentTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class AdministrativeDocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {
        $administrativeDocument = new AdministrativeDocument();
        $uploadedFile     = $this->getUploadedFile();


        $this->assertNull($administrativeDocument->getId());

        $this->assertSame($administrativeDocument, $administrativeDocument->setOriginalFile($uploadedFile));
        $this->assertEquals($uploadedFile, $administrativeDocument->getOriginalFile());
    }

    /**
     * @return UploadedFile
     */
    private function getUploadedFile()
    {
        $uploadedFile = $this->getMockBuilder(UploadedFile::class)
                           ->disableOriginalConstructor()
                           ->getMock();

        return $uploadedFile;
    }
}
