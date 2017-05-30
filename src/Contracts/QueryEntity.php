<?php
declare(strict_types = 1);
namespace DKulyk\Eloquent\Query\Contracts;

use Illuminate\Database\Eloquent\Model;
use RuntimeException;

/**
 * Interface QueryEntity
 *
 * @package DtKt\Contracts
 */
interface QueryEntity
{
    /**
     * @return QueryField[]
     */
    public function getFields(): array;

    /**
     * @param string $field
     *
     * @return QueryField
     *
     * @throws RuntimeException
     */
    public function getField(string $field): QueryField;

    /**
     * @param QueryField[] ...$fields
     *
     * @return QueryEntity
     */
    public function addFields(QueryField ...$fields): QueryEntity;

    /**
     * Get model.
     *
     * @return Model
     */
    public function getModel(): Model;

    /**
     * @param string $name
     *
     * @return QueryEntity
     */
    public function setName(string $name): QueryEntity;

    /**
     * @return string
     */
    public function getName(): string;
}
