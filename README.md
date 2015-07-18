# php-simple-regex

What is it
----------

PhpSimpleRegex is an object oriented regular expressions library for PHP.

This library allows to execute preg_* functions in PHP and use the results as objects, making the use of preg_* functions testeable. PhpSimpleRegex is integrated with [PhpVerbalExpressions](https://github.com/VerbalExpressions/PHPVerbalExpressions) and [Flux](https://github.com/selvinortiz/flux), to allow a full Object Oriented approach to Regular Expressions in PHP.

#### Why Simple?

My native language is spanish and the spanish definition of simple is __"Que es puramente aquello que se dice, sin ninguna característica especial o singular"__, which somehow translates to __"Something that is nothing more than what is told, without any special or singular characteristic"__. That's what I looked for in the design of this library, to be good in what it's intended for and nothing else.

Installation
------------

#### Composer:

If you want to access directly to this repo, adding this to your composer.json should be enough:

```javascript  
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mcustiel/php-simple-regex"
        }
    ],
    "require": {
        "mcustiel/php-simple-regex": "dev-master"
    }
}
```

Or just download the release and include it in your path.

How to use it?
--------------

This library provides a _facade_ class that wraps most of the preg_* functions from PHP. All you need to do is to create an instance of this class and call the methods you need.

```php
use Mcustiel\PhpSimpleRegex\Executor as RegexExecutor;

$regexFacade = new RegexExecutor();
```

#### List of methods:

* MatchResult __getAllMatches__(string $pattern, string $subject, integer $offset = 0)
* Match __getOneMatch__(string $pattern, string $subject, integer $offset = 0)
* boolean __match__(string $pattern, string $subject, integer $offset = 0)
* ReplaceResult __replaceAndCount__(string $pattern, string $replacement, mixed $subject, integer $limit = -1)
* mixed __replace__(string $pattern, string $replacement, mixed $subject, integer $limit = -1)
* mixed __replaceCallback__(string $pattern, callable $callback, mixed $subject, integer $limit = -1)
* ReplaceResult __replaceCallbackAndCount__(string $pattern, callable $callback, mixed $subject, integer $limit = -1)

