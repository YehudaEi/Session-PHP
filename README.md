# Session-PHP
Alternative-Implementation of a PHP session

The project was created out of a need for a PHP session mechanism, without the use of the built-in mechanism (because another part of the code used the built-in mechanism).

For this purpose, I have written a relatively simple library for the implementation of the mechanism.

Happy coding :)

## Security Warning!
It is mandatory to check that the session.json file is stored in a place that is not accessible to anyone !!!

## Example
```php
require_once('lib/SessionClass.php');

SESSION::init();

if(!isset(SESSION::$s['counter'])) SESSION::$s['counter'] = 0;

SESSION::$s['counter']++;

var_dump(SESSION::get());
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## Contact
[SessionPHP@yehudae.net](mailto:SessionPHP@yehudae.net)

## License
[AGPL-3](https://github.com/YehudaEi/Session-PHP/blob/master/LICENSE)
