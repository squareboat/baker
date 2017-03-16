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

Once installation operation is complete, simply add the service provider to your project's `config/app.php` file:

#### Service Provider
```
SquareBoat\Baker\BakerServiceProvider::class,
```

## Usage

`php artisan bake Order`

This is will create the following files - 

A model at `app/Models/Order.php`.

A Repository Contract at `app/Repositories/Contracts/OrderRepository.php`.

A Repository Contract at `app/Repositories/Database/OrderRepository.php`.

A Validator at `app/Validators/OrderValidator.php`.

A Service at `app/Services/OrderService.php`.

A Controller at `app/Http/Controllers/OrderController.php`.
