# PHP-HTTP OpenFaaS Template
Unofficial OpenFaaS template for PHP to use version 8 with psr-7 compatible request/response objects.
Since it already has a golang and a node template with the same single function with request + response object,
I think we should use something like that in PHP aswell.

## Usage
Go to your OpenFaaS project directory and run the following command to pull the template:
```shell
faas-cli template pull https://github.com/Shikachuu/php-http-template
```
Then simply run the following command to generate a function:
```shell
faas-cli new --lang php-http my-function
```
You will find in the newly created directory my-function:
- `src/Handler.php` : entrypoint
- `php-extension.sh` : is for installing PHP extensions if needed
- `composer.json` : is for dependency management


## Using composer packages and PHP extensions
Just add your dependencies to the generated function's `composer.json` file, the build will install them automatically.

To use PHP extensions just modify the `php-extension.sh` file, you can find examples in the file itself
or in the [PHP Docker image docs.](https://github.com/docker-library/docs/blob/master/php/README.md#how-to-install-more-php-extensions)