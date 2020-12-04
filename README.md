<h1 align="center">
    <a href="http://bitbag.shop" target="_blank">
        <img src="doc/logo.png" width="55%" />
    </a>
    <br />
    <a href="https://packagist.org/packages/bitbag/blacklist-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/bitbag/blacklist-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/bitbag/blacklist-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/bitbag/blacklist-plugin.svg" />
    </a>
    <a href="http://travis-ci.org/BitBagCommerce/SyliusbVlacklistPlugin" title="Build status" target="_blank">
            <img src="https://img.shields.io/travis/BitBagCommerce/SyliusblacklistPlugin/master.svg" />
        </a>
    <a href="https://scrutinizer-ci.com/g/BitBagCommerce/SyliusBlacklistPlugin/" title="Scrutinizer" target="_blank">
        <img src="https://img.shields.io/scrutinizer/g/BitBagCommerce/SyliusBlacklistPlugin.svg" />
    </a>
    <a href="https://packagist.org/packages/bitbag/blacklist-plugin" title="Total Downloads" target="_blank">
        <img src="https://poser.pugx.org/bitbag/blacklist-plugin/downloads" />
    </a>
    <p>
        <a href="https://sylius.com/plugins/" target="_blank">
            <img src="https://sylius.com/assets/badge-approved-by-sylius.png" width="85">
        </a>
    </p>
</h1>

## About us

At BitBag we do believe in open source. However, we are able to do it just beacuse of our awesome clients, who are kind enough to share some parts of our work with the community. Therefore, if you feel like there is a possibility for us working together, feel free to reach us out. You will find out more about our professional services, technologies and contact details at https://bitbag.io/.

## BitBag SyliusBlacklistPlugin

This plugin allows you to integrate blacklist features with Sylius platform app.

## Demo

We created a demo app with some useful use-cases of the plugin! Visit [demo.bitbag.shop](https://demo.bitbag.shop) to take a look at it. 
The admin can be accessed under [demo.bitbag.shop/admin](https://demo.bitbag.shop/admin) link and `sylius: sylius` credentials.

## Installation
```bash
$ composer require bitbag/blacklist-plugin
```
    
Add plugin dependencies to your `config/bundles.php` file:
```php
return [
    ...

    BitBag\SyliusBlacklistPlugin\BitBagSyliusBlacklistPlugin::class => ['all' => true],
];
```

Import required config in your `config/packages/_sylius.yaml` file:
```yaml
# config/packages/_sylius.yaml

imports:
    ...
    
    - { resource: "@BitBagSyliusBlacklistPlugin/Resources/config/config.yaml" }
```

Import routing in your `config/routes.yaml` file:

```
# config/routes.yaml

bitbag_sylius_blacklist_plugin:
    resource: "@BitBagSyliusBlacklistPlugin/Resources/config/routing.yaml"
```

Add traits to your Customer entity class, when You don't use annotation.

```php
<?php

declare(strict_types=1);

namespace App\Entity\Customer;

use BitBag\SyliusBlacklistPlugin\Model\FraudStatusTrait;
use Sylius\Component\Core\Model\Customer as BaseCustomer;

class Customer extends BaseCustomer implements CustomerInterface
{
    use FraudStatusTrait;
}
```

Or this way if you use annotations:

```php
<?php

declare(strict_types=1);

namespace App\Entity\Customer;

use Doctrine\ORM\Mapping as ORM;
use BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface;use BitBag\SyliusBlacklistPlugin\Model\FraudStatusTrait;
use Sylius\Component\Core\Model\Customer as BaseCustomer;

/**
* @ORM\Entity 
* @ORM\Table(name="sylius_customer")
*/
class Customer extends BaseCustomer implements CustomerInterface
{
    /**
    * @var string
    * @ORM\Column(type="string", nullable=false)
    */   
    protected $fraudStatus = FraudStatusInterface::FRAUD_STATUS_NEUTRAL;
}
```

If you don't use annotations, define new Entity mapping inside your src/Resources/config/doctrine directory.

```xml
<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping
    xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                            http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd"
>
    <entity name="App\Entity\Customer\Customer" table="sylius_customer">
        <field name="fraudStatus" column="fraud_status" type="string" />
    </entity>
</doctrine-mapping>
```

Create also interface, which is implemented by customer entity

```php
<?php

namespace App\Entity\Customer;

use BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface;
use Sylius\Component\Core\Model\CustomerInterface as BaseCustomerInterface;

interface CustomerInterface extends BaseCustomerInterface, FraudStatusInterface
{
}
```
Override Customer resource:

```yaml
# config/packages/_sylius.yaml
...

sylius_customer:
    resources:
        customer:
            classes:
                model: App\Entity\Customer\Customer
```

Update your database

```
$ bin/console doctrine:migrations:migrate
```

**Note:** If you are running it on production, add the `-e prod` flag to this command.

## Customization

### Available services you can [decorate](https://symfony.com/doc/current/service_container/service_decoration.html) and forms you can [extend](http://symfony.com/doc/current/form/create_form_type_extension.html)

Run the below command to see what Symfony services are shared with this plugin:
```bash
$ bin/console debug:container | grep bitbag_sylius_blacklist_plugin
```

## Testing
```bash
$ composer install
$ cd tests/Application
$ yarn install
$ yarn build
$ bin/console assets:install public -e test
$ bin/console doctrine:schema:create -e test
$ bin/console server:run 127.0.0.1:8080 -d public -e test
$ open http://localhost:8080
$ cd ../..
$ vendor/bin/behat
$ vendor/bin/phpspec run
```

## Contribution

Learn more about our contribution workflow on http://docs.sylius.org/en/latest/contributing/.
