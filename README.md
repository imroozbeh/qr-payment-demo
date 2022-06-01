# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/lumen)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Execution prerequisites

- Databases
  | # | Name | Description |
  | :--- | :---- | :--- |
  | 1 | redis | REDIS_CLIENT=predis <br /> REDIS_HOST=127.0.0.1 <br /> REDIS_PASSWORD= <br /> REDIS_PORT= |
  | 2 | mysql | DB_CONNECTION=mysql <br /> DB_HOST=127.0.0.1 <br /> DB_PORT=3306 <br /> DB_DATABASE= <br /> DB_USERNAME= <br /> DB_PASSWORD= <br /> |

- Supervisors
  | # | Command | Description |
  | :--- | :--- | :--- |
  | 1 | php artisan block:listen |

- Environment variables
  | # | Variables | Description |
  | :--- | :--- | :--- |
  | 1 | FULLNODE_API_PROVIDER=getblock <br /> GETBLOCK_X_API_KEY=5c2dde02-ece0-40d1-be13-9f826a7ad7c6 <br /> GTBLOCK_ENDPOINT=https://eth.getblock.io/testnet/ <br /> GETBLOCK_ID=getblock.io | /config/node-api.php <br /> OR https://eth.getblock.io/mainnet/ for Main Network of Blockchain |
