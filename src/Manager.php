<?php
declare(strict_types=1);

namespace DKulyk\Eloquent\Query;

use RuntimeException;
use InvalidArgumentException;
use DKulyk\Eloquent\Query\Contracts\QueryEntity;
use DKulyk\Eloquent\Query\Contracts\QueryEntityAware;
use DKulyk\Eloquent\Query\Contracts\QueryManager;

/**
 * Class Manager
 *
 * @package DKulyk\Eloquent\Query
 */
class Manager implements QueryManager
{
    /**
     * @var array
     */
    protected $meta = [];

    /**
     * @param QueryEntity|QueryEntityAware $entity
     *
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public function register($entity)
    {
        if ($entity instanceof QueryEntityAware) {
            $entity = $entity->getQueryEntity();
        }
        if ($entity instanceof QueryEntity) {
            $name = $entity->getName();
            if ($this->has($name)) {
                throw new RuntimeException("Meta with name \"{$name}\" already exists.");
            }
            $this->meta[get_class($entity->getModel())] = $entity;
            $this->meta[$name] = $entity;
        } else {
            throw new InvalidArgumentException('Argument must be instanceof QueryEntityAware or QueryEntity.');
        }
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has($id): bool
    {
        return array_key_exists($id, $this->meta);
    }

    /**
     * @param string $id
     *
     * @return QueryEntity
     *
     * @throws RuntimeException
     */
    public function get($id): QueryEntity
    {
        if ($this->has($id)) {
            return $this->meta[$id];
        }

        throw new RuntimeException("Meta with name \"{$id}\" does not exists.");
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->meta;
    }
}
