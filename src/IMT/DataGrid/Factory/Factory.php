<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Factory;

use Symfony\Component\Templating\EngineInterface;

use IMT\DataGrid\Registry\RegistryInterface;
use IMT\DataGrid\Grid;

/**
 * This class represents the grid factory
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class Factory implements FactoryInterface
{
    /**
     * @var RegistryInterface
     */
    protected $registry;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * The constructor method
     *
     * @param RegistryInterface $registry
     * @param EngineInterface   $templating
     */
    public function __construct(
        RegistryInterface $registry,
        EngineInterface $templating
    ) {
        $this->registry   = $registry;
        $this->templating = $templating;
    }

    /**
     * {@inheritDoc}
     */
    public function create()
    {
        return new Grid($this->templating);
    }

    /**
     * {@inheritDoc}
     */
    public function createNamed($name)
    {
        return $this->registry->get($name);
    }
}
