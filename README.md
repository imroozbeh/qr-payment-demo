# QR Payment 


QR Payment is a project for make payment with crypto.
This project listen the block's and if new transaction come make a notification for owner


## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Roozbeh Rahmani at rozbe777@gmail.com. All security vulnerabilities will be promptly addressed.


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
  | 1 | FULLNODE_API_PROVIDER=getblock <br /> GETBLOCK_X_API_KEY=5c2dde02-ece0-40d1-be13-9f826a7ad7c6 <br /> GTBLOCK_ENDPOINT=https://eth.getblock.io/testnet/ <br /> GETBLOCK_ID=getblock.io | - Config File: /config/node-api.php <br /> - https://eth.getblock.io/mainnet/ for Main Network of Blockchain |

## Usage

```php
# install package's 
coposer install 

# listen the block's
php artisan block:listen
```
