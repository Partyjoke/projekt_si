<?php
/**
 * Advertisement repository.
 */

namespace App\Repository;

use App\Entity\Advertisement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;

/**
 * Class AdvertisementRepository.
 *
 * @method Advertisement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advertisement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advertisement[]    findAll()
 * @method Advertisement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertisementRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * AdvertisementRepository constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advertisement::class);
    }

    /**
     * Save record.
     *
     * @param Advertisement $Advertisement Advertisement entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Advertisement $Advertisement): void
    {
        $this->_em->persist($Advertisement);
        $this->_em->flush($Advertisement);
    }

    /**
     * Delete record.
     *
     * @param Advertisement $Advertisement Advertisement entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Advertisement $Advertisement): void
    {
        $this->_em->remove($Advertisement);
        $this->_em->flush($Advertisement);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select('Advertisement', 'category')
            ->join('Advertisement.category', 'category')
            ->orderBy('Advertisement.updatedAt', 'DESC');
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('Advertisement');
    }
}
