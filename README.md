php-obscene-censor-rus
======================
Class for filtering obscene expressions (profanity).

Analysis based on regular expressions with an exclusion list, compatible with UTF8.

Usage:
```php
$text = 'Get the **** out and **** off, you ******* idiot, **** my limp ****!
My granddad is a veteran, and your granddad can **** off too :( **** ****!';

ObsceneCensorRus::filterText($text);

echo $text;
//Get the **** out and **** off, you ******* idiot, **** my limp ****!
//My granddad is a veteran, and your granddad can **** off too :( **** ****!

$text = ObsceneCensorRus::getFiltered($text);

var_dump(ObsceneCensorRus::isAllowed($text));
// false
```
You can specify the character encoding as the second parameter if it differs from UTF8:
```php
ObsceneCensorRus::getFiltered('Who will read this, LOL', 'CP1251');
```
Installation:
```php
composer require vearutop/php-obscene-censor-rus
```
Tests:
```php
php phpunit.phar ./tests
```
Censorship, anti-mat, profanity words, profanity filter, obscene language, vulgar abuse, triangular breasts.
