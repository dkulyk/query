<?php
declare(strict_types = 1);
namespace DKulyk\Eloquent\Query\Contracts;

/**
 * Interface QueryField
 *
 * @package DtKt\Contracts
 */
interface QueryField
{
    /**
     * @return string
     */
    public function getField(): string;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * Add filter to field.
     *
     * @param string[] $filters
     *
     * @return QueryField
     */
    public function setFilters(array $filters): QueryField;

    /**
     * Get field filters.
     *
     * @return QueryFilter[]
     */
    public function getFilters(): array;

    /**
     * @param QueryType|null $type
     *
     * @return QueryField
     */
    public function setType(QueryType $type = null): QueryField;

    /**
     * @return QueryType|null
     */
    public function getType();

    /**
     * Set entity.
     * @param QueryEntity $entity
     */
    public function setEntity(QueryEntity $entity);
}
