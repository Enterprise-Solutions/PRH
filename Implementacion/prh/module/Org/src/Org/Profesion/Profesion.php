<?php

namespace Org\Profesion;
use Doctrine\ORM\Mapping as Orm;
use Zend\Stdlib\Hydrator\ObjectProperty as Hydrator;
use Org\Parte\Parte;

/**
 * @author pislas
 * @Orm\Entity @Orm\Table(name="org_parte_profesion")
 */
class Profesion
{
	/**
	 * @Orm\Id
	 * @Orm\Column(name="org_parte_profesion_id")
	 * @Orm\GeneratedValue(strategy="SEQUENCE")
	 */
	protected $id;
	
	/**
	 * @Orm\Column(name="org_profesion_id")
	 */
	protected $org_profesion_id;
	
	/**
	 * @Orm\Column(name="org_parte_id")
	 */
	protected $orgParteId;
	
	/**
	 * @var Parte
	 * @Orm\OneToOne(targetEntity="Org\Parte\Parte")
	 * @Orm\JoinColumn(name="org_parte_id",referencedColumnName="org_parte_id")
	 */
	protected $parte;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getOrgProfesionId()
	{
	    return $this->org_profesion_id;
	}
	
	public function setParte(Parte $parte)
	{
		if($this->id){
			return $this;
		}
	
		$this->parte = $parte;
		return $this;
	}
	
	public function __construct($orgProfesionId = null)
	{
		if(!$this->org_profesion_id){
			$this->org_profesion_id = $orgProfesionId;
		}
	}
	
	public function toArray()
	{
		return array(
			'org_profesion_id' => $this->org_profesion_id	
		);
	}
}