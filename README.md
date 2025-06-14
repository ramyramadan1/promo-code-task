<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installation Steps

- sudo docker compose up -d --build

## To login to container 
- docker exec -it {container-id} sh

## To see running Containers 
- docker ps 

## To run tests 
- php artisan test

## Cases coverd 
- create new user ( admin )
- create new user ( user )
- give permission to admin only to generate promo code
- check if admin can generate promo code with only code without (max_usage , expiry  , user_ids )
- check if admin can generate promo code with only code , max_usage without ( expiry  , user_ids )
- check if admin can generate promo code with only code , max_usage , expiry  without ( user_ids )
- check if admin can generate promo code with only code , max_usage , expiry  , user_id without ( max_usage_per_user)
- check on user if he is able to generate promo code .
- check if user can not add promo code .
- check if user can redeem promo code  (assigned to him).
- check if user can not redeem promo code ( if he reach to max usage assigned to him )
- check if user can redeem promo code ( not assigned to him but not reach to max usage )
- check promo code can not be used when it's expired by admin .
- check promo cod could not be used because it read to it's expiry date .

