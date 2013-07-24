Ifbyphone XML Generator
=======================

[![Build Status](https://travis-ci.org/Opus1no2/Ifbyphone-XML-Responses.png)](https://travis-ci.org/Opus1no2/Ifbyphone-XML-Responses)
 
A simple interface for creating valid Ifbyphone XML structures

Installation
------------

Installation is conveniently provided via Composer.

To get started, install composer in your project:

```sh
$ curl -s https://getcomposer.org/installer | php
```

Next, add a composer.json file containing the following:

```js
}
    "require": {
        "ifbypone/xml-structures": "dev-master"
    }
}
```

Finall, install!

```sh
$ php composer.phar install
```

Usage
-----

Using the class is easy:

``` php
<?php

require_once 'path/to/Ifbyphone/Route.php'

$route = new Route();

//Perform a blind transfer
echo $route->transfer(800357****);

//Route to an IVR
echo $route->survo(1234);

//Gracefully end a call
echo $route->hangup();

```

License:
--------
MIT
