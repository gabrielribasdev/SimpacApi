<?php

// src/Repository/UsuarioAvaliadorRepository.php

namespace App\Repository;

use App\Entity\UsuarioAvaliador;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UsuarioAvaliadorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsuarioAvaliador::class);
    }

    /**
     * Retorna uma página de avaliadores.
     */
    public function findAvaliadoresPaginated(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;

        return $this->createQueryBuilder('ua')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Retorna o total de avaliadores.
     */
    public function countAvaliadores(): int
    {
        return (int) $this->createQueryBuilder('ua')
            ->select('COUNT(ua.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

       public function findAvaliadoresId($id)
       {
           return $this->createQueryBuilder('u')
               ->andWhere('u.id = :val')
               ->setParameter('val', $id)
               ->getQuery()
               ->getResult()
           ;
       }
       public function deleteById($id)
        {
            return $this->createQueryBuilder('u')
                ->delete()  
                ->where('u.id = :val') 
                ->setParameter('val', $id)
                ->getQuery()
                ->execute();  
        }

}

