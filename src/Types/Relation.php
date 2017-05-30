<?php
declare(strict_types=1);

namespace DKulyk\Eloquent\Query\Types;

use InvalidArgumentException;
use DKulyk\Eloquent\Query\Contracts\QueryEntity;
use DKulyk\Eloquent\Query\Contracts\QueryEntityAware;

/**
 * Class Relation
 *
 * @package DKulyk\Eloquent\Query\Types
 */
class Relation extends AbstractType
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var
     */
    protected $entity;

    /**
     * @param QueryEntity|QueryEntityAware $entity
     *
     * @throws InvalidArgumentException
     */
    public function __construct($entity)
    {
        if ($entity instanceof QueryEntityAware) {
            $entity = $entity->getQueryEntity();
        }
        if ($entity instanceof QueryEntity) {
            $this->name = $entity->getName();
        } else {
            throw new InvalidArgumentException('Argument must be instanceof QueryEntityAware or QueryEntity.');
        }

        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getFilter(): array
    {
        return [
            'data' => [
                'type' => 'relation',
                'entity' => $this->name
            ]
        ];
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }
}
