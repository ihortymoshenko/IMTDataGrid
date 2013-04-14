<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Column;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * This class represents the grid column
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class Column implements ColumnInterface
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
    public function getOption($option)
    {
        return $this->options[$option];
    }

    /**
     * {@inheritDoc}
     */
    public function hasOption($option)
    {
        return array_key_exists($option, $this->options);
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
                'index',
                'name',
            )
        );
    }
}
