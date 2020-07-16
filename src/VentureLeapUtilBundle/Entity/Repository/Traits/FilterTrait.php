<?php

namespace VentureLeapUtilBundle\Entity\Repository\Traits;

use Doctrine\ORM\QueryBuilder;

trait FilterTrait
{
    public static $PLACEHOLDER_PREFIX = 'param_';

    protected function addLikeFilter(QueryBuilder $queryBuilder, $name, $value): QueryBuilder
    {
        return $this->addComparisonFilter($queryBuilder, $name, '%'.$value.'%', 'LIKE');
    }

    protected function addSuffixLikeFilter(QueryBuilder $queryBuilder, $name, $value): QueryBuilder
    {
        return $this->addComparisonFilter($queryBuilder, $name, '%'.$value, 'LIKE');
    }

    protected function addPrefixLikeFilter(QueryBuilder $queryBuilder, $name, $value): QueryBuilder
    {
        return $this->addComparisonFilter($queryBuilder, $name, $value.'%', 'LIKE');
    }

    protected function addIdentityFilter(QueryBuilder $queryBuilder, $name, $value): QueryBuilder
    {
        return $this->addComparisonFilter($queryBuilder, $name, $value, '=');
    }

    protected function addLessFilter(QueryBuilder $queryBuilder, $name, $value): QueryBuilder
    {
        return $this->addComparisonFilter($queryBuilder, $name, $value, '<');
    }

    protected function addLessOrEqualFilter(QueryBuilder $queryBuilder, $name, $value): QueryBuilder
    {
        return $this->addComparisonFilter($queryBuilder, $name, $value, '<=');
    }

    protected function addMoreFilter(QueryBuilder $queryBuilder, $name, $value): QueryBuilder
    {
        return $this->addComparisonFilter($queryBuilder, $name, $value, '>');
    }

    protected function addMoreOrEqualFilter(QueryBuilder $queryBuilder, $name, $value): QueryBuilder
    {
        return $this->addComparisonFilter($queryBuilder, $name, $value, '>=');
    }

    protected function addComparisonFilter(QueryBuilder $queryBuilder, $name, $value, $comparison): QueryBuilder
    {
        if (null !== $value) {
            $randomPlaceholder = static::$PLACEHOLDER_PREFIX.uniqid();

            $queryBuilder
                ->andWhere(
                    $name.' '.$comparison.' :'.$randomPlaceholder
                )
                ->setParameter($randomPlaceholder, $value)
            ;
        }

        return $queryBuilder;
    }

    protected function addContainmentFilter(QueryBuilder $queryBuilder, $name, $value): QueryBuilder
    {
        return $this->addCollectionFilter($queryBuilder, $name, $value, 'IN');
    }

    protected function addNotContainmentFilter(QueryBuilder $queryBuilder, $name, $value): QueryBuilder
    {
        return $this->addCollectionFilter($queryBuilder, $name, $value, 'NOT IN');
    }

    protected function addNullFilter(QueryBuilder $queryBuilder, $name): QueryBuilder
    {
        return $queryBuilder->andWhere(
                    $name.' IS NULL'
                );
    }

    protected function addCollectionFilter(QueryBuilder $queryBuilder, $name, $value, $comparison): QueryBuilder
    {
        if (null !== $value) {
            $randomPlaceholder = static::$PLACEHOLDER_PREFIX.uniqid();

            $queryBuilder
                ->andWhere(
                    $name.' '.$comparison.' (:'.$randomPlaceholder.')'
                )
                ->setParameter($randomPlaceholder, $value)
            ;
        }

        return $queryBuilder;
    }
}
