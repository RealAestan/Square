<?php

namespace App\Infrastructure\Security\ApiKey;

use App\Infrastructure\Security\ApiKey\Repository\ApiKeyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: ApiKeyRepository::class)]
class ApiKey implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $key;

    #[ORM\Column(type: 'integer', length: 255, options: ['unsigned' => true])]
    private int $quota = 10;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function useQuota(): void
    {
        --$this->quota;
    }

    public function getQuota(): int
    {
        return $this->quota;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getUserIdentifier(): string
    {
        return $this->key;
    }

    public function eraseCredentials(): void
    {
    }
}
