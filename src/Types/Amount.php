<?php
declare(strict_types=1);

namespace DKulyk\Eloquent\Query\Types;

/**
 * Class Amount
 *
 * @package DKulyk\Eloquent\Query\Types
 */
class Amount extends AbstractType
{
    /**
     * @var int
     */
    protected $precision;

    /**
     * @var int
     */
    protected $multiplier;

    /**
     * @var array
     */
    protected $options;

    /**
     * Amount constructor.
     *
     * @param int $precision
     * @param int $multiplier
     * @param array $options
     */
    public function __construct($precision = 2, $multiplier = 1, array $options = [])
    {
        $this->precision = $precision;
        $this->multiplier = $multiplier;
        $this->options = array_merge($options, ['decimals' => $precision]);
    }

    /**
     * @inheritdoc
     */
    public function prepareValue($value)
    {
        return $value * $this->multiplier;
    }

    /**
     * @inheritdoc
     */
    public function getFilter(): array
    {
        return [
            'data' => [
                'type' => 'amount',
                'options' => $this->options
            ]
        ];
    }
}
