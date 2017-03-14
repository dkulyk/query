<?php
declare(strict_types=1);
namespace DKulyk\Eloquent\Query\Contracts;

/**
 * Interface QueryEntityAware
 *
 * @package DtKt\Query\Contracts
 */
interface QueryEntityAware
{
    /**
     * @return QueryEntity
     */
    public function getQueryEntity():QueryEntity;
}
