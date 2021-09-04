<?php

namespace App\Repository;

use App\Entity\User;
use App\Data\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param string $role
     *
     * @return array
     */
    public function findByRole($role)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from($this->_entityName, 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"'.$role.'"%');

        return $qb->getQuery()->getResult();
    }

     /**
     * @return User[]
     */
    public function findSearch(SearchData $search): array
    {
        $query = $this
                    ->createQueryBuilder('p')
                    ->select('c', 'p')
                    ->join('p.skills', 'c');
                    // ->andWhere('p.nom LIKE :nom')
                    // ->setParameter("nom", "%{$search->nom}%");
                    // ->addSelect('a')
                    // ->Where('a.nom LIKE :nom')
                    // // ->andWhere('a.skills LIKE :skill')
                    // ->orWhere('a.prenom LIKE :search')
                    // // ->andWhere('a.skills LIKE :value')
                    // ->setParameter(':search', $r.nom)
                    // // ->setParameter(':value', $skills);
                    // ->leftJoin('a.skills', 'skill');
        if(!empty($search->nom)){
            $query = $query
                ->andWhere('p.nom LIKE :nom')
                ->orWhere('p.prenom LIKE :nom')
                ->setParameter('nom', "%{$search->nom}%");
        }

        if(!empty($search->skills)){
            $query = $query 
                ->andWhere('c.id IN (:skills)')
                ->setParameter('skills', $search->skills);
        }
        try {
            return $query->getQuery()->getResult();
        }
        catch(\Exception $e) {
            throw new \Exception('problème '. $e->getMessage(). $e->getFile());
        }
    }
}
