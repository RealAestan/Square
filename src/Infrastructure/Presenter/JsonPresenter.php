<?php

namespace App\Infrastructure\Presenter;

use App\Application\Adapter\Presenter\OutputInterface;
use App\Application\Adapter\Presenter\PaginatedCollectionOutputInterface;
use App\Application\Adapter\Presenter\PresenterInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JsonPresenter implements PresenterInterface
{
    public const ERROR_INVALID_OUTPUT_INTERFACE = 'ERROR_INVALID_OUTPUT_INTERFACE';

    /**
     * @var array|object|scalar
     */
    private $data;

    public function present(OutputInterface $output): void
    {
        if ($output instanceof PaginatedCollectionOutputInterface) {
            $this->data = [
                'data' => $output->getArray(),
                'page' => $output->getPage(),
                'size' => $output->getSize(),
                'total' => $output->getTotal(),
            ];
        } else {
            throw new \Exception(self::ERROR_INVALID_OUTPUT_INTERFACE);
        }
    }

    public function getJson(): string
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->serialize($this->data, 'json');
    }
}
