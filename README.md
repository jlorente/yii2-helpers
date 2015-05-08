Yii2 Helpers
=====================

A collection of Yii2 helpers with a variety of purposes

## Included helpers:

*QueryStreamIterator* - QueryStreamIterator provides an Iterator for large query 
resultsets that are likely to spend a large amount of memory. 

## Installation

Include the package as dependency under the bower.json file.

To install, either run

```bash
$ php composer.phar require jlorente/yii2-helpers "*"
```

or add

```json
...
    "require": {
        // ... other configurations ...
        "jlorente/yii2-helpers": "*"
    }
```

to the ```require``` section of your `composer.json` file.

## Usage

###QueryStreamIterator

Imagine you have a table of cities with 1000000 rows and you want to iterate 
over all of them. Performing a normal query you will fetch 1000000 results at 
the same time and the memory consumption will increase. 

This iterator allows you to wrap a QueryInterface object inside it and iterate 
over the whole resultset, but only fetching the number of results that you 
establish at the same time. 

i.e.:
```php
use jlorente\helpers\QueryStreamIterator;

$cities = new QueryStreamIterator([
    'query' => City::find(),
    'dataStreamSize' => 500
]);
foreach ($cities as $city) {
    echo $city->name . PHP_EOL;
}
```

Where the query property is the QueryInterface object and the dataStreamSize is 
number of results to fetch at the same time. You have to consider that the higher 
this number is, the higher the Iteration speed, but the memory comsumption will 
be also higher and vice versa.

## License 
Copyright &copy; 2015 José Lorente Martín <jose.lorente.martin@gmail.com>.
Licensed under the MIT license. See LICENSE.txt for details.