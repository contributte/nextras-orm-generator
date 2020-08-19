# Nextras ORM generator

## Content
- [Installation](https://github.com/contributte/nextras-orm-generator/blob/master/.docs/README.md#usage)
- [Usage - how to run](https://github.com/contributte/nextras-orm-generator/blob/master/.docs/README.md#usage)
- [Configuration - how to configure](https://github.com/contributte/nextras-orm-generator/blob/master/.docs/README.md#configuration)

## Installation
Most common way to install this tool is with composer:
```sh
composer require --dev contributte/nextras-orm-generator
```
This script does not require to be part of your project so you can install it anywhere you like and just provide path to desired dir where entities will be generated.


## Usage
1) Generate all entities in same folder (together)
```php
$config = [
    'output' => __DIR__ . '/model/together',
    //other options
    ];
$factory = new SimpleFactory(
	new TogetherConfig($config),
	new DatabaseAnalyser('mysql:host=127.0.0.1;dbname=nextras_orm_generator', 'root')
);

$factory->create()->generate();
```

2. Generate entities separately
```php
$config = [
    'output' => __DIR__ . '/model/separated',
    //other options
    ];
$factory = new SimpleFactory(
	new SeparateConfig($config),
	new DatabaseAnalyser('mysql:host=127.0.0.1;dbname=nextras_orm_generator', 'root')
);

$factory->create()->generate();
```

You can also see example in our playground:
https://github.com/contributte/playground/tree/master/nextras-orm-generator

## Configuration
This tool is highly configurable, take a look at configuration class for list of all available options:
https://github.com/contributte/nextras-orm-generator/tree/master/src/Config
