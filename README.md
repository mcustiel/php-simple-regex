# php-simple-regex

What is it
----------

PhpSimpleRegex is an object oriented regular expressions library for PHP.

This library allows to execute preg_* functions in PHP and use the results as objects, making the use of preg_* functions testeable. PhpSimpleRegex is integrated with [VerbalExpressions\PHPVerbalExpressions\VerbalExpressions](https://github.com/VerbalExpressions/PHPVerbalExpressions), [SelvinOrtiz\Utils\Flux\Flux](https://github.com/selvinortiz/flux) and also [MarkWilson\VerbalExpression](https://github.com/markwilson/VerbalExpressionsPhp) to allow a full Object Oriented approach to Regular Expressions in PHP.

Installation
------------

#### Composer:

If you want to access directly to this repo, adding this to your composer.json should be enough:

```json
{
    "require": {
        "mcustiel/php-simple-regex": "*"
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

* MatchResult __getAllMatches__(mixed $pattern, string $subject, integer $offset = 0)
* Match __getOneMatch__(mixed $pattern, string $subject, integer $offset = 0)
* boolean __match__(mixed $pattern, string $subject, integer $offset = 0)
* ReplaceResult __replaceAndCount__(mixed $pattern, string $replacement, mixed $subject, integer $limit = -1)
* mixed __replace__(mixed $pattern, string $replacement, mixed $subject, integer $limit = -1)
* mixed __replaceCallback__(mixed $pattern, callable $callback, mixed $subject, integer $limit = -1)
* ReplaceResult __replaceCallbackAndCount__(mixed $pattern, callable $callback, mixed $subject, integer $limit = -1)
* array __split__(mixed $pattern, string $string, integer $limit = -1, bool $returnOnlyNotEmpty = false, bool $captureOffset = false, bool $captureSubpatterns = false)
* array __grep__(mixed $pattern, array $input)
* array __grepNotMatching__(mixed $pattern, array $input)

For each method, the pattern can be a string, a Flux object, or a PhpVerbalExpression object.

Examples:
---------

#### getAllMatches:

```php
try {
    $result = $regexFacade->getAllMatches('/\d+/', 'ab12cd34ef56');
    echo 'Number of matches: ' . $result->getMatchesCount() . PHP_EOL; // Prints 3
    echo 'First match: ' . $result->getMatchAt(0)->getFullMatch() . PHP_EOL; // Prints 12
    
    // Iterate over results
    foreach ($result as $index => $match) {
        echo "Match at index {$index} is " . $match->getFullMatch() . PHP_EOL; 
    }
} catch (\Exception $e) {
    echo 'An error occurred executing getAllMatches';
}
```

#### getOneMatch:

```php
try {
    $result = $regexFacade->getOneMatches('/\d+/', 'ab12cd34ef56');
    if (!empty($result)) {
        echo 'Match: ' . $result->getFullMatch() . PHP_EOL; // Prints 12
    }
} catch (\Exception $e) {
    echo 'An error occurred executing getOneMatch';
}
```

#### match:

```php
try {
    if ($regexFacade->match('/\d+/', 'ab12cd34ef56')) {
        echo 'String matches pattern.'. PHP_EOL;
    } else {
        echo 'String does not match pattern.'. PHP_EOL;
    }
} catch (\Exception $e) {
    echo 'An error occurred executing match';
}
```

#### replaceAndCount:

```php
try {
    // Subject can also be an array.
    $result = $this->executor->replaceAndCount('/\d+/', 'potato', 'ab12cd34ef56');
    echo 'Number of replacements: ' . $result->getReplacements() . PHP_EOL;
    echo 'Replaced string: ' . $result->getResult() . PHP_EOL;
} catch (\Exception $e) {
    echo 'An error occurred executing replaceAndCount';
}
```

#### replace:

```php
try {
    // Subject can also be a string.
    $result = $this->executor->replaceAndCount('/\d+/', 'potato', ['ab12cd34ef56', 'ab12cd78ef90']);
    echo 'Replaced strings: ' . print_r($result->getResult(), true) . PHP_EOL;
} catch (\Exception $e) {
    echo 'An error occurred executing replace';
}
```

#### replaceCallback:

```php
try {
    // Subject can also be an array.
    $result = $this->executor->replaceCallback('/\d+/', function () { return 'potato'; }, 'ab12cd34ef56');
    echo 'Replaced string: ' . $result->getResult() . PHP_EOL;
} catch (\Exception $e) {
    echo 'An error occurred executing replaceCallback';
}
```

#### replaceCallbackAndCount:

```php
try {
    // Subject can also be an array.
    $result = $this->executor->replaceCallback('/\d+/', function () { return 'potato'; }, 'ab12cd34ef56');
    echo 'Number of replacements: ' . $result->getReplacements() . PHP_EOL;
    echo 'Replaced string: ' . $result->getResult() . PHP_EOL;
} catch (\Exception $e) {
    echo 'An error occurred executing replaceCallbackAndCount';
}
```
