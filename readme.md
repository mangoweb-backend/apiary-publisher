# Apiary Publisher

[![Downloads this Month](https://img.shields.io/packagist/dm/mangoweb/apiary-publisher.svg)](https://packagist.org/packages/mangoweb/apiary-publisher)
[![Stable version](http://img.shields.io/packagist/v/mangoweb/apiary-publisher.svg)](https://packagist.org/packages/mangoweb/apiary-publisher)


## Installation

Use composer:

```bash
$ composer require mangoweb/apiary-publisher
```


## Usage example

### Symfony Console

Register `Mangoweb\ApiaryPublisher\Bridges\SymfonyConsole\ApiaryPublishCommand` to your Symfony Console application.

```php
$app = new Symfony\Component\Console\Application();
$app->add(new Mangoweb\ApiaryPublisher\Bridges\SymfonyConsole\ApiaryPublishCommand);
```

```bash
# bin/console apiary:publish --name <apiName> --token <apiToken>                    <blueprintPath>
$ bin/console apiary:publish --name pollsapi  --token 874887d6ecd0b106a47448c5beca1 blueprint.apib
```

### CLI

```bash
# apiary-publish <apiName> <apiToken>                    <blueprintPath>
$ apiary-publish pollsapi  874887d6ecd0b106a47448c5beca1 blueprint.apib
```

### PHP

```php
$apiName = 'pollsapi';
$apiToken = '874887d6ecd0b106a47448c5beca1';
$code = file_get_contents(__DIR__ . '/blueprint.apib');

$publisher = new ApiaryPublisher($apiName, $apiToken);
$publisher->publish($code);
```


## License

MIT. See full [license](license.md).
