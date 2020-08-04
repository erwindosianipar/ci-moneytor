## Moneytor Apps CodeIgniter

Moneytor Apps CodeIgniter is an web based application used to "Moneytoring" money. Used to monitor money like spending or incomming money

[Demo](https://moneytors.herokuapp.com)

## Whats is CodeIgniter

CodeIgniter is an Application Development Framework - a toolkit - for people who build web sites using PHP. Its goal is to enable you to develop projects much faster than you could if you were writing code from scratch, by providing a rich set of libraries for commonly needed tasks, as well as a simple interface and logical structure to access these libraries. CodeIgniter lets you creatively focus on your project by minimizing the amount of code needed for a given task.

## CodeIgniter PHP Mailer

PHPMailer - A full-featured email creation and transfer class for PHP

## Installation

### Config

Application config was automatic set to detect root base

### Database

Create database `moneytor` and import `keuangan.sql`

Set in database.php

```
$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'moneytor',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
```

## Test your app

Open in browser

```
http://localhost/moneytor/
```
