URL shortener library
=====================

This library allows you to shorten a URL, reverse is also possible.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c4e06c9d-547c-47bb-8abb-fccc68b7df7a/big.png)](https://insight.sensiolabs.com/projects/c4e06c9d-547c-47bb-8abb-fccc68b7df7a)

[![Build Status](https://api.travis-ci.org/pixxet/UrlShortener.png?branch=master)](https://travis-ci.org/pixxet/UrlShortener)
[![Total Downloads](https://poser.pugx.org/pixxet/url-shortener/downloads.png)](https://packagist.org/packages/pixxet/url-shortener)
[![Latest Stable Version](https://poser.pugx.org/pixxet/url-shortener/v/stable.png)](https://packagist.org/packages/pixxet/url-shortener)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/pixxet/UrlShortener/badges/quality-score.png?s=34c4ba6b0cd272673fa121c32a63e1ce668b9b2a)](https://scrutinizer-ci.com/g/pixxet/UrlShortener/)
[![Code Coverage](https://scrutinizer-ci.com/g/pixxet/UrlShortener/badges/coverage.png?s=7a8c3388ae7b50f35fd548b4b7874526c634e8c5)](https://scrutinizer-ci.com/g/pixxet/UrlShortener/)

**Basic Docs**

* [Installation](#installation)
* [Bit.ly API](#bitly-api)
* [Google API](#google-api)
* [Chain providers](#chain-providers)
* [Retrieve link](#retrieve-link)
* [Contribution](#contribution)

<a name="installation"></a>

## Installation

Only 1 step:

### Download UrlShortener using composer

Add UrlShortener in your composer.json:

```js
{
    "require": {
        "pixxet/url-shortener": "dev-master"
    }
}
```

Now tell composer to download the library by running the command:

``` bash
$ php composer.phar update pixxet/url-shortener
```

Composer will install the library to your project's `vendor/pixxet` directory.

<a name="bitly-api"></a>

## Bit.ly API

### Shorten

```php
<?php

use Pixxet\UrlShortener\Model\Link;
use Pixxet\UrlShortener\Provider\Bitly\BitlyProvider;
use Pixxet\UrlShortener\Provider\Bitly\OAuthClient;

$link = new Link;
$link->setLongUrl('http://www.google.com');

$bitlyProvider = new BitlyProvider(
    new OAuthClient('username', 'password'), // or new GenericAccessTokenAuthenticator('generic_access_token')
    array('connect_timeout' => 1, 'timeout' => 1)
);

$bitlyProvider->shorten($link);
```

You can also use the commands provided by this library, look at the help message:

```bash
$ bin/shortener bitly:shorten --help
```

Some arguments are mandatory:

```bash
$ bin/shortener bitly:shorten username password http://www.google.com
```

Some options are available:

```bash
$ bin/shortener bitly:shorten username password http://www.google.com --options='{"connect_timeout":1,"timeout":1}'
```

### Expand

```php
<?php

use Pixxet\UrlShortener\Model\Link;
use Pixxet\UrlShortener\Provider\Bitly\BitlyProvider;
use Pixxet\UrlShortener\Provider\Bitly\OAuthClient;

$link = new Link;
$link->setShortUrl('http://goo.gl/fbsS');

$bitlyProvider = new BitlyProvider(
    new OAuthClient('username', 'password'), // or new GenericAccessTokenAuthenticator('generic_access_token')
    array('connect_timeout' => 1, 'timeout' => 1)
);

$bitlyProvider->expand($link);
```

```bash
$ bin/shortener bitly:expand --help
```

Some arguments are mandatory:

```bash
$ bin/shortener bitly:expand username password http://bit.ly/ze6poY
```

Some options are available:

```bash
$ bin/shortener bitly:expand username password http://bit.ly/ze6poY --options='{"connect_timeout":1,"timeout":1}'
```

<a name="google-api"></a>

## Google API

### Shorten

```php
<?php

use Pixxet\UrlShortener\Model\Link;
use Pixxet\UrlShortener\Provider\Google\GoogleProvider;

$link = new Link;
$link->setLongUrl('http://www.google.com');

$googleProvider = new GoogleProvider(
    'api_key',
    array('connect_timeout' => 1, 'timeout' => 1)
);

$googleProvider->shorten($link);
```

You can also use the commands provided by this library, look at the help message:

```bash
$ bin/shortener google:shorten --help
```

Only one argument is mandatory (the long URL) but you can also provide a Google
API key:

```bash
$ bin/shortener google:shorten http://www.google.com
```

```bash
$ bin/shortener google:shorten http://www.google.com api_key
```

Some options are available:

```bash
$ bin/shortener google:shorten http://www.google.com --options='{"connect_timeout":1,"timeout":1}'
```

### Expand

```php
<?php

use Pixxet\UrlShortener\Model\Link;
use Pixxet\UrlShortener\Provider\Google\GoogleProvider;

$link = new Link;
$link->setShortUrl('http://goo.gl/fbsS');

$googleProvider = new GoogleProvider(
    'api_key',
    array('connect_timeout' => 1, 'timeout' => 1)
);

$googleProvider->expand($link);
```

```bash
$ bin/shortener google:expand --help
```

Only one argument is mandatory (the short URL) but you can also provide a
Google API key:

```bash
$ bin/shortener google:expand http://goo.gl/fbsS
```

```bash
$ bin/shortener google:expand http://goo.gl/fbsS api_key
```

Some options are available:

```bash
$ bin/shortener google:expand http://goo.gl/fbsS --options='{"connect_timeout":1,"timeout":1}'
```

<a name="chain-providers"></a>

## Chain providers

```php
<?php

use Pixxet\UrlShortener\Model\Link;
use Pixxet\UrlShortener\Provider\ChainProvider;

$chainProvider = new ChainProvider;
$chainProvider->addProvider($bitlyProvider);
$chainProvider->addProvider($googleProvider);
// add yours...

$link = new Link;
$link->setLongUrl('http://www.google.com');

$chainProvider->getProvider('bitly')->shorten($link);

$chainProvider->getProvider('google')->expand($link);
```

<a name="retrieve-link"></a>

## Retrieve link

You can retrieve some links using these finders:

```php
<?php

use Pixxet\UrlShortener\Model\LinkManager;

$linkManager = new LinkManager($chainProvider);

$shortened = $linkManager->findOneByProviderAndShortUrl('bitly', 'http://bit.ly/ze6poY');

$expanded = $linkManager->findOneByProviderAndLongUrl('google', 'http://www.google.com');
```

<a name="contribution"></a>

## Contribution

Any question or feedback? Open an issue and I will try to reply quickly.

A feature is missing here? Feel free to create a pull request to solve it!

I hope this has been useful and has helped you. If so, share it and recommend
it! :)



Credentials [@mremitsme](https://twitter.com/mremitsme)

[@pixxetde](https://twitter.com/pixxetde)
