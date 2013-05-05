[![Build Status](https://travis-ci.org/IgorTimoshenko/IMTDataGrid.png?branch=master)](https://travis-ci.org/IgorTimoshenko/IMTDataGrid)
[![Coverage Status](https://coveralls.io/repos/IgorTimoshenko/IMTDataGrid/badge.png?branch=master)](https://coveralls.io/r/IgorTimoshenko/IMTDataGrid)
[![Dependencies Status](https://d2xishtp1ojlk0.cloudfront.net/d/9434169)](http://depending.in/IgorTimoshenko/IMTDataGrid)

# IMTDataGrid #

## Overview ##

This library provides a simple, powerful and fully customizable tool for
generating data-bound grids.

## Installation ##

### 1. Using Composer (recommended) ###

To install `IMTDataGrid` with [Composer][1] just add the following to your
`composer.json` file:

```json
{
    // ...
    "require": {
        // ...
        "imt/data-grid": "dev-master"
        // ...
    }
    // ...
}
```

Then, you can install the new dependencies by running [Composer][1]'s update
command from the directory where your `composer.json` file is located:

```sh
$ php composer.phar update imt/data-grid
```

Now, [Composer][1] will automatically download all required files, and install
them for you.

## License ##

This libray is released under the MIT license. See the complete license in the
`LICENSE` file that is distributed with this source code.

[1]: http://getcomposer.org