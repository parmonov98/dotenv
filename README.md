# DotEnv class

## steps

```
-composer require parmonov98/dotenv
-include or require composer autoloader into your project 
-import class using "use Parmonov98\DotEnv"
-Create a new object and use it as you want.
```

examples

```php

require_once "dotenv.php";
$env = new DotEnv(); // you can pass a custom name instead .env
$env->get("BOT_NAME");
$env->set("BOT_NAME", "new name");
// saving into new file or .env
$env->save("new-file");
//refresh params from file content
$env->refresh();

```
