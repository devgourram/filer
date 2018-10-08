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

	private $filerClass;

	private $directoryPrefix;

	private $documentType;


	public function __construct($resizingFilters, $waterMarkFilter, $class, $filerClass, $directoryPrefix, $documentType)
	{
		$this->resizingFilters = $resizingFilters;
		$this->waterMarkFilter = $waterMarkFilter;
		$this->class = $class;
		$this->filerClass = $filerClass;
		$this->directoryPrefix = $directoryPrefix;
		$this->$documentType = $documentType;
	}

	public static function createConfiguration($configs)
	{
		return new Configuration(
			$configs['resizingFilters'], 
			$configs['waterMarkFilter'], 
			$configs['class'], 
			$configs['filerClass'], 
			$configs['directoryPrefix'], 
			$configs['documentType']
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

	public function getFilerClass()
	{
		return $this->filerClass;
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