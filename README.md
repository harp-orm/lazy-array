Lazy Array
==========

[![Build Status](https://travis-ci.org/harp-orm/lazy-array.svg?branch=master)](https://travis-ci.org/harp-orm/lazy-array)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/harp-orm/lazy-array/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/harp-orm/lazy-array/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/harp-orm/lazy-array/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/harp-orm/lazy-array/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/harp-orm/lazy-array/v/stable.png)](https://packagist.org/packages/harp-orm/lazy-array)

An array which contents can be loaded only when needed

Instalation
-----------

Install via composer

```
composer require harp-orm/lazy-array
```

Usage
-----
```
$arr = new LazyArray($loader);

// This is where the loader->load() method gets executed
echo $arr[2];
```

License
-------

Copyright (c) 2015, Clippings Ltd. Developed by Ivan Kerin

Under BSD-3-Clause license, read LICENSE file.
