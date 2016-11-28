company user
============
company user api

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mycone/yii2-company-user "*"
```

or add

```
"mycone/yii2-company-user": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply modify your application configuration as follows :

```php
return [
    'modules' => [
        'users' => [
            'class' => 'mycone\users\Module',
            ...
        ]
        ...
    ],
    ...
];
```

