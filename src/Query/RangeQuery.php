<?php

declare(strict_types=1);

namespace Erichard\ElasticQueryBuilder\Query;

use Erichard\ElasticQueryBuilder\Contracts\QueryInterface;
use Erichard\ElasticQueryBuilder\Features\HasField;
use Erichard\ElasticQueryBuilder\QueryException;

class RangeQuery implements QueryInterface
{
    use HasField;

    public function __construct(
        string $field,
        protected int|float|string|null $lt = null,
        protected int|float|string|null $gt = null,
        protected int|float|string|null $lte = null,
        protected int|float|string|null $gte = null,
    ) {
        $this->field = $field;
    }

    public function gt(int|float|string|null $value): self
    {
        $this->gt = $value;

        return $this;
    }

    public function lt(int|float|string|null $value): self
    {
        $this->lt = $value;

        return $this;
    }

    public function gte(int|float|string|null $value): self
    {
        $this->gte = $value;

        return $this;
    }

    public function lte(int|float|string|null $value): self
    {
        $this->lte = $value;

        return $this;
    }

    public function build(): array
    {
        $query = [];

        if ($this->gt !== null) {
            $query['gt'] = $this->gt;
        }

        if ($this->lt !== null) {
            $query['lt'] = $this->lt;
        }

        if ($this->gte !== null) {
            $query['gte'] = $this->gte;
        }

        if ($this->lte !== null) {
            $query['lte'] = $this->lte;
        }

        if (empty($query)) {
            throw new QueryException('Empty RangeQuery');
        }

        return [
            'range' => [
                $this->field => $query,
            ],
        ];
    }
}
