[![Build Status](https://travis-ci.org/IgorTimoshenko/IMTDataGrid.png?branch=master)](https://travis-ci.org/IgorTimoshenko/IMTDataGrid)
[![Coverage Status](https://coveralls.io/repos/IgorTimoshenko/IMTDataGrid/badge.png?branch=master)](https://coveralls.io/r/IgorTimoshenko/IMTDataGrid)
[![Dependencies Status](https://depending.in/IgorTimoshenko/IMTDataGrid.png)](http://depending.in/IgorTimoshenko/IMTDataGrid)

# IMTDataGrid #

## Overview ##

This library provides a simple, powerful and fully customizable tool for binding
grids on the client-side with data on the server. The library does not provide
any tools for rendering grids on the client-side. So you pick yourself library
that will render grids on the client-side (one of the such libraries is
[jqGrid][1]). However, the library provides the opportunity to create an object
of the grid, which contains the name, options, and a collection of columns.
Therefore, you can use this object in order to simplify rendering grids on the
client-side.

## Installation ##

### 1. Using Composer (recommended) ###

To install `IMTDataGrid` with [Composer][2] just add the following to your
`composer.json` file:

```json
{
    "require": {
        "imt/data-grid": "0.9.*"
    }
}
```

Then, you can install the new dependencies by running Composer's update command
from the directory where your `composer.json` file is located:

```sh
$ php composer.phar update imt/data-grid
```

Now, Composer will automatically download all required files, and install them
for you.

## Usage ##

Suppose you are building a simple blog and you need to have the grid on the
back-end, which will display information about the posts.

> It is further assumed that you are going to use the jqGrid library for
> rendering grids on the client-side, as well as [Doctrine ORM][3] as the data
> source.

To get started, you need to construct an object that will reflect the grid with
information about the posts. In order to construct this object you need to
create the grid builder that will be responsible for creation of the grid:

```php
<?php
namespace Acme\PostBundle\DataGrid\Builder;

use Symfony\Component\Routing\RouterInterface;

use Doctrine\ORM\EntityManager;

use IMT\DataGrid\Builder\AbstractBuilder;
use IMT\DataGrid\Column\Column;
use IMT\DataGrid\DataSource\Doctrine\ORM\DataSource;

class PostBuilder extends AbstractBuilder
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * The constructor method
     *
     * @param RouterInterface $router
     * @param EntityManager   $entityManager
     */
    public function __construct(
        RouterInterface $router,
        EntityManager $entityManager
    ) {
        $this->router        = $router;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritDoc}
     */
    public function buildColumns()
    {
        $this
            ->dataGrid
            ->addColumn(
                new Column(
                    array(
                        'index' => 'p.id',
                        'label' => 'Id',
                        'name'  => 'post_id',
                    )
                )
            )
            ->addColumn(
                new Column(
                    array(
                        'index' => 'p.title',
                        'label' => 'Title',
                        'name'  => 'title',
                    )
                )
            );
    }

    /**
     * {@inheritDoc}
     */
    public function buildDataSource()
    {
        $queryBuilder = $this
            ->entityManager
            ->createQueryBuilder()
            ->select(
                'p',
                'p.id AS post_id',
                'p.title'
            )
            ->from('AcmePostBundle:Post', 'p');

        $this->dataGrid->setDataSource(new DataSource($queryBuilder));
    }

    /**
     * {@inheritDoc}
     */
    public function buildOptions()
    {
        $this
            ->dataGrid
            ->setName('posts')
            ->setOptions(
                array(
                    'caption'  => 'Posts',
                    'datatype' => 'json',
                    'mtype'    => 'get',
                    'pager'    => '#posts_pager',
                    'rowList'  => array(
                        10,
                        20,
                        30,
                    ),
                    'rowNum'   => 10,
                    'url'      => $this
                        ->router
                        ->generate('acme_post_post_get_posts'),
                )
            );
    }
}
```

> An object of the column in the constructor method takes an array of options.
> There are four options: `index`, `label`, `name`, and `template`. The first
> three are required. You can also pass more options, if necessary. For
> instance, if needed pass them to the library on the client-side.

All that is left to do is to get the grid manager in the controller and build
the grid using by the grid builder:

```php
<?php
namespace Acme\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use IMT\DataGrid\HttpFoundation\JqGridRequest;

use Acme\PostBundle\DataGrid\Builder\PostBuilder;

class PostController extends Controller
{
    /**
     * @Method("GET")
     * @Route("/posts/", name="acme_post_post_get_posts")
     * @Template("AcmePostBundle:Post:list.html.twig")
     */
    public function getPostsAction(Request $request)
    {
        $dataGrid = $this
            ->getDataGridManager()
            ->setBuilder(
                new PostBuilder(
                    $this->getRouter(),
                    $this->getDoctrine()->getEntityManager()
                )
            )
            ->buildDataGrid()
            ->getDataGrid();

        if ($request->isXmlHttpRequest()) {
            $dataGrid->bindRequest(new JqGridRequest($request));

            return new Response(
                json_encode($dataGrid->getData()),
                200,
                array(
                    'Content-Type' => 'application/json',
                )
            );
        }

        return array(
            'dataGrid' => $dataGrid->createView(),
        );
    }

    /**
     * @return \IMT\DataGrid\Manager\ManagerInterface
     */
    private function getDataGridManager()
    {
        return $this->get('imt_data_grid.manager');
    }

    /**
     * @return \Symfony\Component\Routing\RouterInterface
     */
    private function getRouter()
    {
        return $this->get('router');
    }
}
```

> Because was specified the `url` option for the grid, after rendering the grid
> on the client-side will be made an additional request to the server to
> retrieve data. So you need to bind with the grid the request that came to the
> server.

Once the construction of the grid using by the grid builder is finished, you
need to call the `createView` method which will create an object of the grid
view. You can pass this object into the template to configure rendering the grid
on the client-side:

```html
{# in AcmePostBundle:Post:list.html.twig #}
{% extends '::base.html.twig' %}

{% block stylesheets %}
    {{ parent() }}

    {% stylesheets
        filter='?cssrewrite,?yui_css'
        output='css/jqGrid.css'
        '@AcmePostBundle/Resources/public/js/lib/jqGrid/4.4.5/css/ui.jqgrid.css'
    %}
        <link rel="stylesheet" href="{{ asset_url }}" />
    {% endstylesheets %}
{% endblock %}

{% block body %}
    <table id="{{ dataGrid.getName }}"><tr><td/></tr></table>
    <div id="{{ dataGrid.getName }}_pager"></div>
{% endblock %}

{% block javascripts %}
    {{ parent() }}

    {% javascripts
         filter='?yui_js'
         output='js/jqGrid.js'
        '@AcmePostBundle/Resources/public/js/lib/jqGrid/4.4.5/js/i18n/grid.locale-en.js'
        '@AcmePostBundle/Resources/public/js/lib/jqGrid/4.4.5/js/jquery.jqGrid.min.js'
    %}
        <script src="{{ asset_url }}"></script>
    {% endjavascripts %}

    <script>
        {% set colModel = [] %}
        {% set colNames = [] %}
        {% for column in dataGrid.getColumns %}
            {% set colModel = colModel|merge([column.toArray]) %}
            {% set colNames = colNames|merge([column.get('label')]) %}
        {% endfor %}

        {% set options = dataGrid.getOptions %}
        {% set options = options|merge({'colModel':colModel}) %}
        {% set options = options|merge({'colNames':colNames}) %}

        $(function(){
            $('#' + '{{ dataGrid.getName }}').jqGrid({{ options|json_encode|raw }});
            $('#' + '{{ dataGrid.getName }}').jqGrid('filterToolbar',{stringResult:true});
            $('#' + '{{ dataGrid.getName }}').jqGrid('navGrid','{{ '#' ~ dataGrid.getName ~ '_pager' }}');
        });
    </script>
{% endblock %}
```

That is all. You should see on the client-side the grid with information about
the posts. As you can see, to create the grid that is bound with data on the
server and with the ability to search is very easy.

## Testing ##

```sh
$ make test
```

## Contributing ##

Please see [CONTRIBUTING][4] for details.

## Credits

- [Igor Timoshenko][5]
- [All Contributors][6]

## License ##

This library is released under the MIT license. See the complete license in the
`LICENSE` file that is distributed with this source code.

[1]: http://github.com/tonytomov/jqGrid
[2]: http://getcomposer.org
[3]: http://github.com/doctrine/doctrine2
[4]: https://github.com/IgorTimoshenko/IMTDataGrid/blob/master/CONTRIBUTING.md
[5]: https://github.com/IgorTimoshenko
[6]: https://github.com/IgorTimoshenko/IMTDataGrid/graphs/contributors
