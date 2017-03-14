<?php
declare(strict_types = 1);
namespace DKulyk\Eloquent\Query\Filters;

/**
 * Class Like
 *
 * @package DtKt\Query\Filters
 */
class Like extends Operator
{
    protected $operator = 'like';
    protected $not = 'not like';

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return '~';
    }
}
