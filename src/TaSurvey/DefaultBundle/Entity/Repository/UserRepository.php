<?php
namespace TaSurvey\DefaultBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use TaSurvey\DefaultBundle\Entity\User;

/**
 * UserRepository.
 *
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class UserRepository extends EntityRepository
{
    public function getSearchQuery($key = '')
    {
        $dql = "SELECT e FROM TaSurveyDefaultBundle:User e WHERE e.number LIKE :key OR e.code LIKE :key";
        $query = $this->getEntityManager()->createQuery($dql);
        $query = $query->setParameter('key', "%$key%");

        return $query;
    }
}
