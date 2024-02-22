# yii2-contacts

This package implements the base functionality needed for a CRM or contacts management system. It establishes administrative and front end interfaces for people to enter their contact information and addresses. This package contains all of the former elements of brianvb/yii2-membership and that package has become focused on only memberships.

In order to use this package, migrations must be run to install the required database tables. Add the following to console application configuration:
```php
[
	'controllerMap' => [
	    'migrate' => [
	        'class' => \yii\console\controllers\MigrateController::class,
	        'migrationNamespaces' => [
	            'yiicontacts\console\migrations',
	        ],
	    ],
	],
]
```

Any applications using this package require some base bootstrapping to be done. Add this to application configurations:
```php
[
    'bootstrap' => [
        'yiicontacts-base' => [ 'class' => \yiicontacts\bootstrap\Base::class ],
    ],
]
```

This package is designed to easily drop into an application with the AdminKit theme. To do so, add the following to bootstrap configuration:
```php
[
    'bootstrap' => [
        'yiicontacts-adminkit' => [ 'class' => \yiicontacts\bootstrap\Adminkit::class ],
    ],
]
```

Add the following to an application configuration where where users are managing their own contact information:
```php
    'bootstrap' => [
        'yiicontacts-frontend' => [ 'class' => \yiicontacts\frontend\Bootstrap::class ],
    ],
```