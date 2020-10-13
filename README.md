# CodeIgniter 4 Project - Dispertapahorbun

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible, and secure. 
More information can be found at the [official site](http://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the 
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [the announcement](http://forum.codeigniter.com/thread-62615.html) on the forums.

The user guide corresponding to this version of the framework can be found
[here](https://codeigniter4.github.io/userguide/). 

## Installation & updates

Clone git project ini menggunakan git bawaan masing masing ke folder **htdocs** untuk yang menggunakan xampp, atau memakai github desktop,
Project CodeIgniter 4 ini menggunakan Server Requirement yang tercantum di bawah readme doc ini.

Setelah di clone, silahkan buka Command Prompt atau Visual Studio Code dan buka terminal, jalankan
`composer update` untuk mendapatkan file vendor codeigniter 4 serta librarynya, biasanya membutuhkan waktu

## Setup

File `.env` bisa diambil dari mengcopy file `env`.
Jangan lupa untuk rename dan tambahkan titik didepannya

Project ini belum pakai migration, jadi silahkan impor sql ke database `dispertapahorbun` atau sesuaikan dengan isi `.env` nya.
Sedangkan seed, anda bisa pakai menggunakan `php spark db:seed AdminSeeder`. 
Isi seeder bisa dilihat di `App\Database\Seeds\AdminSeeder.php`.

## Jalanin Local Dev Server

Silahkan buka command prompt pada project ini, dan jalankan
`php spark serve`, default lokasi ada di `http://localhost:8080`

## Deprecation Notice on PHP Version 7.2

Didasarkan pada [supported version di website php](https://www.php.net/supported-versions.php) yang akan berakhir tanggal 30 November 2020.

Serta CodeIgniter mewanti-wanti untuk [next version](https://forum.codeigniter.com/thread-77054.html) CodeIgniter 4.1 yang kemungkinan release tanggal 1 November yang memungkinkan minimal versi PHP yang digunakan adalah 7.3, 
disarankan untuk upgrade ke versi baru yaitu versi 7.3. atau lebih baik 7.4

Namun untuk diperhatikan bahwa mengupgrade komponen php tidaklah mudah, maka untuk user xampp bisa **membackup/export** keseluruhan database, dan htdocs,
setelah itu silahkan menguninstall xampp, memasang xampp yang memiliki php versi 7.4, dan mengembalikan htdocs, serta import database hasil export ke phpmyadmin terbaru

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

User Guide for CodeIgniter 4 available at [here](https://codeigniter.com/user_guide/index.html)

## Repository Management

We use Github issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script. 
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 7.2 or higher is required, with the following extensions installed: .

Lokasi (`Xampp\php\php.ini`), anda akan menemukan `extension=(nama ekstension)`.

*tips*: Untuk aktifkan, hilangkan `;` pada depan kata extension.

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)

## Library that used in this project

- [SweetAlert2](https://sweetalert2.github.io/)
- [WYSIWYG TinyMCE Editor](https://www.tiny.cloud/docs/quick-start/)
