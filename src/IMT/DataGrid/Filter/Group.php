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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents the grid filter group
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class Group implements GroupInterface
{
    /**
     * A collection of objects of type GroupInterface
     *
     * @var ArrayCollection
     */
    protected $groups;

    /**
     * An array of options
     *
     * @var array
     */
    protected $options = array();

    /**
     * A collection of objects of type RuleInterface
     *
     * @var ArrayCollection
     */
    protected $rules;

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

        $this->groups = new ArrayCollection();
        $this->rules  = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function addGroup(GroupInterface $group)
    {
        $this->groups->add($group);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addRule(RuleInterface $rule)
    {
        $this->rules->add($rule);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getGroupOp()
    {
        return $this->options['groupOp'];
    }

    /**
     * {@inheritDoc}
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * {@inheritDoc}
     */
    public function getRules()
    {
        return $this->rules;
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
                'groupOp',
            )
        );

        $resolver->setAllowedTypes(
            array(
                'groupOp' => array('string'),
            )
        );

        $resolver->setAllowedValues(
            array(
                'groupOp' => array(
                    'AND',
                    'OR',
                )
            )
        );
    }
}
