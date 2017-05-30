<?php
declare(strict_types=1);

namespace DKulyk\Eloquent\Query\Types;

use DKulyk\Eloquent\Query\Contracts\QueryType;

/**
 * Class AbstractType
 *
 * @package DKulyk\Eloquent\Query\Types
 */
abstract class AbstractType implements QueryType
{
    /**
     * @inheritdoc
     */
    public function prepareValue($value)
    {
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function printValue($value): string
    {
        return $value;
    }
}
