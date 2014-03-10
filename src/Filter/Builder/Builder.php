<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Filter\Builder;

use IMT\DataGrid\Filter\Filter;
use IMT\DataGrid\Filter\Rule;

/**
 * This class represents the data grid filter builder
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class Builder implements BuilderInterface
{
    /**
     * {@inheritDoc}
     */
    public function build(array $data)
    {
        $filter = new Filter(
            array_intersect_key($data, array_flip(array('groupOp')))
        );

        $filters = !array_key_exists('groups', $data)
            ? array()
            : $data['groups'];

        foreach ($filters as $data) {
            $filter->addFilter($this->build($data));
        }

        $rules = !array_key_exists('rules', $data)
            ? array()
            : $data['rules'];

        foreach ($rules as $rule) {
            $filter->addRule(new Rule($rule));
        }

        return $filter;
    }
}
