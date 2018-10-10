<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 02/10/18
 * Time: 08:51
 */

namespace Iad\Bundle\FilerTechBundle\Config;

class Configuration
{
	private $resizingFilters;

	private $waterMarkFilter;

	private $class;

	private $directoryPrefix;

	private $documentType;


	public function __construct($resizingFilters, $waterMarkFilter, $class, $directoryPrefix, $documentType)
	{
		$this->resizingFilters = $resizingFilters;
		$this->waterMarkFilter = $waterMarkFilter;
		$this->class = $class;
		$this->directoryPrefix = $directoryPrefix;
		$this->documentType = $documentType;
	}

	public static function createConfiguration($configs)
	{
		return new Configuration(
            (isset($configs['resizing_filters']) ? $configs['resizing_filters'] : []),
			(isset($configs['water_markfilter']) ? true : false), 
			$configs['class'],
			$configs['directory_prefix'], 
			$configs['document_type']
			);
	}


	public function getResizingFilers()
	{
		return $this->resizingFilters;
	}

	public function getWaterMarkFiler()
	{
		return $this->waterMarkFilter;
	}

	public function getClass()
	{
		return $this->class;
	}

	public function getDirectoryPrefix()
	{
		return $this->directoryPrefix;
	}

	public function getDocumentType()
	{
		return $this->documentType;
	}
}