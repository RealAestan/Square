<?php

namespace App\Infrastructure\Security\ApiKey\Repository;

use App\Infrastructure\Security\ApiKey\ApiKey;
use App\Infrastructure\Security\ApiKey\Helper\ApiKeyGenerator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApiKey>
 *
 * @method ApiKey|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiKey|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiKey[]    findAll()
 * @method ApiKey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiKeyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiKey::class);
    }

    public function createNewApiKey(): ApiKey
    {
        do {
            $key = ApiKeyGenerator::generate();
            $keyExist = $this->findOneBy(['key' => $key]) instanceof ApiKey;
        } while ($keyExist);

        $apiKey = new ApiKey($key);

        $this->save($apiKey, true);

        return $apiKey;
    }

    public function save(ApiKey $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ApiKey $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
