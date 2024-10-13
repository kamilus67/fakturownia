# Fakturownia

Biblioteka dla wszystkich metod dostępnych w [Fakturownia API](https://app.fakturownia.pl/api/).

[![Latest stable version](https://img.shields.io/badge/aktualna_wersja-v2.0.0-blue)](https://packagist.org/packages/pisystems/fakturownia)
[![PHP version](https://img.shields.io/badge/php->=8.2.0-blue)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green)](licencja)

[Wersja angielska english version](./README.md)

## Instalacja

Instalacja za pomocą [Composer](https://getcomposer.org):
```console
composer require pisystems/fakturownia
```

Instalacja za pomocą [Git](https://git-scm.com) przez SSH:
```console
git clone git@github.com:kamilus67/fakturownia.git
```

Instalacja za pomocą [Git](https://git-scm.com) przez HTTPS:
```console
git clone https://github.com/kamilus67/fakturownia.git
```

## Konfiguracja

Jedyne, co musisz zrobić, to ustawić token API za pomocą $this-> (przykłady poniżej). Token API można wygenerować w ustawieniach Fakturownia.
 ```php
$this->setToken('mojtoken');
 ```

## Logi

Biblioteka wykorzystuje system logowania do zapisywania wszystkich potwierdzeń i powiadomień wysyłanych przez serwer Faktur, wychodzących żądań oraz wyjątków. Upewnij się, że katalog tmp/logs ma uprawnienia do zapisu i dodaj regułę w pliku .htaccess dla Apache lub w NGINX, aby zablokować dostęp przeglądarki do tego obszaru.

Zapisywanie logów jest domyślnie włączone, ale możesz wyłączyć tę funkcję:
 ```php
Logger::disableLogging();
 ```

Możesz również ustawić własną ścieżkę do logów za pomocą tego polecenia:
 ```php
Logger::setLogPath('/my/own/path/Logs/');
 ```

Możesz także ustawić własny Logger za pomocą tego polecenia, musi być on kompatybilny z `Psr\Log\LoggerInterface`:
```php
Logger::setLogger(new CustomLogger());
```

Nazwy plików logów są generowane automatycznie.

## Licencja

Ta biblioteka jest wydana na podstawie [Licencji MIT](http://www.opensource.org/licenses/MIT)