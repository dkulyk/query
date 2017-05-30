<?php
declare(strict_types=1);

namespace DKulyk\Eloquent\Query\Contracts;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use RuntimeException;

/**
 * Interface Manager
 *
 * @package DKulyk\Eloquent\Query\Contracts
 */
interface QueryManager extends ContainerInterface
{
    /**
     * Create a new entity instance.
     *
     * @param QueryEntity|QueryEntityAware $entity
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function register($entity);
}
