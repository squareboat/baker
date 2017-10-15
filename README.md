# A set of helpers for baking your Laravel Project.
```
         ,,,,,
        _|||||_ 
       {~*~*~*~}
     __{*~*~*~*}__ 
    `-------------`
```

## Install

### Install via composer

```
$ composer require squareboat/baker
```

### Configure Laravel

> If you are using __laravel 5.5__ or higher then you should skip this step.

If you are using laravel 5.4 or 5.3, simply add the service provider to your project's `config/app.php` file:

#### Service Provider
```
SquareBoat\Baker\BakerServiceProvider::class,
```

## Usage

`php artisan bake Order`

This is will create the following files - 

A model at `app/Models/Order.php`.

A Repository Contract at `app/Repositories/Contracts/OrderRepository.php`.

A Repository at `app/Repositories/Database/OrderRepository.php`.

A Validator at `app/Validators/OrderValidator.php`.

A Service at `app/Services/OrderService.php`.

A Controller at `app/Http/Controllers/OrderController.php`.

### You can also use the options

1. Bake with a different name

`--repository="MyOrder"` to make a service with the name **MyOrderRepository**

`--validator="MyOrder"` to make a service with the name **MyOrderValidator**

`--service="MyOrder"` to make a service with the name **MyOrderService**

`--controller="MyOrder"` to make a service with the name **MyOrderController**

2. Avoid baking of some classes

`--no-repository` to not bake repository along with the model

`--no-validator` to not bake validator along with the model

`--no-service` to not bake service along with the model

`--no-controller` to not bake controller along with the model

## Security

If you discover any security related issues, please email amit.gupta@squareboat.com instead of using the issue tracker.

## Credits

- [Amit Gupta](https://github.com/akaamitgupta)
- [All Contributors](../../contributors)

## About SquareBoat

[SquareBoat](https://squareboat.com) is a startup focused, product development company based in Gurgaon, India. You'll find an overview of all our open source projects [on GitHub](https://github.com/squareboat).

# License

The MIT License. Please see [License File](LICENSE.md) for more information. Copyright © 2016 [SquareBoat](https://squareboat.com)
