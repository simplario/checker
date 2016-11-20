# Checker

Check provision like a boss

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


## Install
- PHP 5.6+

``` bash
# via composer
$ composer require simplario/checker
```

## Testing
``` bash
$ composer test
```

## Build and setup checker.phar
``` bash
# build file 'checker.phar'
$ composer phar

# setup
$ sudo chmod +x checker.phar && mv checker.phar /usr/bin/checker
```

## Start working

1) create file 'checker.php' (or checker.yaml / checker.yml / checker.json) - look at /example/
``` php
<?php
return [
    'tasks' => [
        // default checker ( filesystem / gateway / phpExtension / service / storagePdo ... )
        ['checker' => 'filesystem', 'path' => __FILE__, 'exists' => true, 'readable' => true],
        // custom checker
        ['checker' => Simplario\Checker\Checker\Filesystem::class, 'path' => __FILE__, 'exists' => true],
    ],
];
```
2) Run 'checker'
``` bash
# run vie composer bin
$ ./vendor/bin/checker checker.php

# run global
$ checker checker.yml
```


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/simplario/checker.svg
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[ico-travis]: https://img.shields.io/travis/simplario/checker/master.svg
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/simplario/checker.svg
[ico-code-quality]: https://img.shields.io/scrutinizer/g/simplario/checker.svg
[ico-downloads]: https://img.shields.io/packagist/dt/simplario/checker.svg

[link-packagist]: https://packagist.org/packages/simplario/checker
[link-travis]: https://travis-ci.org/simplario/checker
[link-scrutinizer]: https://scrutinizer-ci.com/g/simplario/checker/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/simplario/checker
[link-downloads]: https://packagist.org/packages/simplario/checker
[link-author]: https://github.com/vlad-groznov
[link-contributors]: ../../contributors