# DotEnv class

## steps

```
-create dotenv.php file or clone
-include or require into your project
-create and use methods
```


examples
```php

require_once "dotenv.php";
$env = new DotEnv();
$env->get("BOT_NAME");
$env->set("BOT_NAME", "new name");
// saving into new file or .env
$env->save("new-file");

```

