<?php

namespace Zeega\DataBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Table;

class LayerRepository extends EntityRepository
{
    public function findByMultipleIds($layers)
    {
		return $this->getEntityManager()
        			->createQueryBuilder()
        			->add('select', 'l')
        			->from('ZeegaDataBundle:Layer', 'l')
					->where('l.id in (:layers)')
                    ->andWhere('l.enabled = true')
					->setParameters(array('layers'=>$layers))
 					->getQuery()
 					->getResult();
	}
	
}
