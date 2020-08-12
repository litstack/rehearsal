# Fjord Testbench

An [orchestra](https://github.com/orchestral/testbench) extension to simplify
testing fjord packages in a laravel application environment that has fjord
installed.

## Installation

Install the package via composer:

```shell
composer require --dev fjuse/testbench
```

## Usage

To run tests in a fjord environment, your test class only needs to extend
`Fjuse\Testbench\TestCase`.

```php
use Fjuse\Testbench\TestCase as FjordTestCase;

class TestCase extends FjordTestCase
{
    public function test_fjord_is_installed()
    {
        $this->assertTrue(fjord()->installed());
    }
}
```

This testcase is an extension of `Orchestra\Testbench\TestCase`. All its
functions can be used. Read more on how to test your packages in the
[orchestra docs](https://github.com/orchestral/testbench)
