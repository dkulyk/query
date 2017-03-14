<?php
declare(strict_types=1);
namespace DKulyk\Eloquent\Query;

use DtKt\Query\Contracts\QueryEntity;
use DtKt\Query\Contracts\QueryField;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Entity
 *
 * @package DtKt\Query
 */
class Entity implements QueryEntity
{
    /**
     * @var Model|null
     */
    protected $model;

    /**
     * @var QueryField[]
     */
    protected $fields = [];

    /**
     * Client constructor.
     *
     * @param Model|null $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @inheritdoc
     */
    public function addFields(QueryField ...$fields): QueryEntity
    {
        foreach ($fields as $field) {
            $field->setEntity($this);
            $this->fields[$field->getField()] = $field;
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}
