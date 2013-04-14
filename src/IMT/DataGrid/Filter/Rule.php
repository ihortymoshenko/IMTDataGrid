<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Filter;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * This class represents the grid filter rule
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class Rule implements RuleInterface
{
    /**
     * An array of options
     *
     * @var array
     */
    protected $options = array();

    /**
     * The constructor method
     *
     * @param array $options An array of options
     */
    public function __construct(array $options)
    {
        $resolver = new OptionsResolver();

        $this->setDefaultOptions($resolver);

        $this->options = $resolver->resolve($options);
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        return $this->options['data'];
    }

    /**
     * {@inheritDoc}
     */
    public function getField()
    {
        return $this->options['field'];
    }

    /**
     * {@inheritDoc}
     */
    public function getOp()
    {
        return $this->options['op'];
    }

    /**
     * Sets the default options
     *
     * @param OptionsResolverInterface $resolver
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(
            array(
                'data',
                'field',
                'op',
            )
        );

        $resolver->setAllowedTypes(
            array(
                'data'  => array('string'),
                'field' => array('string'),
                'op'    => array('string'),
            )
        );

        $resolver->setAllowedValues(
            array(
                'op' => array(
                    'bn',
                    'bw',
                    'cn',
                    'en',
                    'eq',
                    'ew',
                    'ge',
                    'gt',
                    'in',
                    'le',
                    'lt',
                    'nc',
                    'ne',
                    'ni',
                )
            )
        );
    }
}
