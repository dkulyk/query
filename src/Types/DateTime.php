<?php
declare(strict_types=1);
namespace DKulyk\Eloquent\Query\Types;

use DKulyk\Eloquent\Query\Contracts\QueryType;

/**
 * Class Date
 *
 * @package DtKt\Query\Types
 */
class DateTime implements QueryType
{
    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $printFormat;

    /**
     * Date constructor.
     *
     * @param string $format
     * @param string $printFormat
     */
    public function __construct($format = 'Y-m-d', $printFormat = 'm/d/Y')
    {
        $this->format = $format;
        $this->printFormat = $printFormat;
    }

    /**
     * @inheritdoc
     */
    public function prepareValue($value)
    {
        return (new \DateTime($value))->format($this->format);
    }

    /**
     * @inheritdoc
     */
    public function printValue($value): string
    {
        return (new \DateTime($value))->format($this->printFormat);
    }
}
