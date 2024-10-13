# Fakturownia

Library for all methods available in [Fakturownia API](https://app.fakturownia.pl/api/).

[![Latest stable version](https://img.shields.io/badge/current_version-v2.0.0-blue)](https://packagist.org/packages/pisystems/fakturownia)
[![PHP version](https://img.shields.io/badge/php->=8.2.0-blue)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

[Polish version wersja polska](./README_PL.md)

## Installation

Install via [Composer](https://getcomposer.org):
```console
composer require pisystems/fakturownia
```

Install via [Git](https://git-scm.com) over SSH:
```console
git clone git@github.com:kamilus67/fakturownia.git
```

Install via [Git](https://git-scm.com) over HTTPS:
```console
git clone https://github.com/kamilus67/fakturownia.git
```

## Configuration

All you need to do is set the API token using $this-> (examples below). The API token can be generated in the Fakturownia settings.
 ```php
$this->setToken('myowntoken');
 ```

## Logs

The library uses the logging system to save all confirmations and notifications sent by the Invoice server, outgoing requests and exceptions.
Make sure that the `tmp/logs` directory is writable and add a rule to Apache `.htaccess` or NGINX to block browser access to this area.

Logging is enabled by default, but you can disable this feature:
 ```php
Logger::disableLogging();
 ```

You can also set your own logging path by this command:
 ```php
Logger::setLogPath('/my/own/path/Logs/');
 ```

You can also set you own Logger by this command it has to be compatible with `Psr\Log\LoggerInterface`:
```php
Logger::setLogger(new CustomLogger());
```

The logs file names is generated automatically.

## License

This library is released under the [MIT License](http://www.opensource.org/licenses/MIT)