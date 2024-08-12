# [![](https://bitbag.io/wp-content/uploads/2021/05/Blacklist.png)](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=plugins_blacklist)

# BitBag SyliusBlacklistPlugin

----

[ ![](https://img.shields.io/packagist/l/bitbag/blacklist-plugin.svg) ](https://packagist.org/packages/bitbag/blacklist-plugin "License")
[ ![](https://img.shields.io/packagist/v/bitbag/product-bundle-plugin.svg) ](https://packagist.org/packages/bitbag/blacklist-plugin "Version")
[ ![](https://img.shields.io/github/actions/workflow/status/BitBagCommerce/SyliusBlacklistPlugin/build.yml?branch=main) ](https://github.com/BitBagCommerce/SyliusBlacklistPlugin/actions "Build status")
[ ![](https://poser.pugx.org/bitbag/blacklist-plugin/downloads)](https://packagist.org/packages/bitbag/blacklist-plugin "Total Downloads")
[ ![Slack](https://img.shields.io/badge/community%20chat-slack-FF1493.svg)](http://sylius-devs.slack.com)
[ ![Support](https://img.shields.io/badge/support-contact%20author-blue])](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=plugins_blacklist)

At BitBag we do believe in open source. However, we are able to do it just because of our awesome clients, who are kind enough to share some parts of our work with the community. Therefore, if you feel like there is a possibility for us to work  together, feel free to reach out. You will find out more about our professional services, technologies, and contact details at [https://bitbag.io/](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=plugins_blacklist).

Like what we do? Want to join us? Check out our job listings on our [career page](https://bitbag.io/career/?utm_source=github&utm_medium=referral&utm_campaign=career). Not familiar with Symfony & Sylius yet, but still want to start with us? Join our [academy](https://bitbag.io/pl/akademia?utm_source=github&utm_medium=url&utm_campaign=akademia)!

# Table of Content

***

* [Overview](#overview)
* [Support](#we-are-here-to-help)
* [Installation](#installation)
  * [Testing](#testing)
  * [Customization](#Customization)
* [About us](#about-us)
  * [Community](#community)
* [Demo](#demo-sylius-shop)
* [License](#license)
* [Contact](#contact)

# Overview

----
This plugin allows you to integrate blacklist features with Sylius platform app.


## We are here to help
This **open-source plugin was developed to help the Sylius community**. If you have any additional questions, would like help with installing or configuring the plugin, or need any assistance with your Sylius project - let us know!

[![](https://bitbag.io/wp-content/uploads/2020/10/button-contact.png)](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=plugins_blacklist)

## Installation
```bash
composer require bitbag/blacklist-plugin --no-scripts
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

Define new Entity mapping inside your src/Resources/config/doctrine directory.

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

Or edit Customer Entity this way if you use annotations:

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

    public function getFraudStatus(): ?string
    {
        return $this->fraudStatus;
    }

    public function setFraudStatus(?string $fraudStatus): void
    {
        $this->fraudStatus = $fraudStatus;
    }
}
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
                repository: App\Repository\Customer\CustomerRepository
```

Create or edit `CustomerRepository.php` file:
```php
<?php

declare(strict_types=1);

namespace App\Repository\Customer;

use BitBag\SyliusBlacklistPlugin\Repository\CustomerRepositoryTrait;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\CustomerRepository as BaseCustomerRepository;

class CustomerRepository extends BaseCustomerRepository
{
    use CustomerRepositoryTrait;
}
```

Override Customer grid:

```yaml
# config/packages/_sylius.yaml
...

sylius_grid:
    grids:
        sylius_admin_customer:
            fields:
                ...
                fraudStatus:
                    type: twig
                    label: bitbag_sylius_blacklist_plugin.ui.fraud_status
                    options:
                        template: "@BitBagSyliusBlacklistPlugin/Customer/Grid/Field/fraudStatus.html.twig"
            filters:
                ...
                fraudStatus:
                    type: select
                    label: bitbag_sylius_blacklist_plugin.ui.fraud_status
                    form_options:
                        choices:
                            bitbag_sylius_blacklist_plugin.ui.neutral: Neutral
                            bitbag_sylius_blacklist_plugin.ui.blacklisted: Blacklisted
```

```yaml
# config/packages/twig.yaml
...

twig:
  paths: ['%kernel.project_dir%/templates']
  debug: '%kernel.debug%'
  strict_variables: '%kernel.debug%'
  form_themes:
    - '@BitBagSyliusBlacklistPlugin/Form/theme.html.twig'
    - '@SyliusUi/Form/theme.html.twig'
services:
  _defaults:
    public: false
    autowire: true
    autoconfigure: true

  Twig\Extra\Intl\IntlExtension: ~

when@test_cached:
  twig:
    strict_variables: true

```

Override Customer form template (`@SyliusAdminBundle\Customer\_form.html.twig`) by adding lines below

```html
<div class="ui segment">
    <h4 class="ui dividing header">{{ 'bitbag_sylius_blacklist_plugin.ui.fraud_status'|trans }}</h4>
    {{ form_row(form.fraudStatus) }}
</div>
```

Update your database

```bash
bin/console doctrine:migrations:migrate
```

**Note:** If you are running it on production, add the `-e prod` flag to this command.

Update your database schema:

```bash
bin/console doctrine:schema:update --dump-sql
```

If the list includes only changes for updating the database by adding 'fraud_status' you can use:

```bash
bin/console doctrine:schema:update -f
```

If there are another changes, please make sure they will not destroy your database schema.

## Functionalities

All main functionalities of the plugin are described [here.](doc/functionalities.md)

## Customization

### Available services you can [decorate](https://symfony.com/doc/current/service_container/service_decoration.html) and forms you can [extend](http://symfony.com/doc/current/form/create_form_type_extension.html)

Run the below command to see what Symfony services are shared with this plugin:
```bash
bin/console debug:container | grep bitbag_sylius_blacklist_plugin
```

## Testing
```bash
composer install
cd tests/Application
yarn install
yarn build
bin/console assets:install public -e test
bin/console doctrine:schema:create -e test
bin/console server:run 127.0.0.1:8080 -d public -e test
open http://localhost:8080
cd ../..
vendor/bin/behat
vendor/bin/phpspec run
```

# About us

---

BitBag is a company of people who **love what they do** and do it right. We fulfill the eCommerce technology stack with **Sylius**, Shopware, Akeneo, and Pimcore for PIM, eZ Platform for CMS, and VueStorefront for PWA. Our goal is to provide real digital transformation with an agile solution that scales with the **clients’ needs**. Our main area of expertise includes eCommerce consulting and development for B2C, B2B, and Multi-vendor Marketplaces.</br>
We are advisers in the first place. We start each project with a diagnosis of problems, and an analysis of the needs and **goals** that the client wants to achieve.</br>
We build **unforgettable**, consistent digital customer journeys on top of the **best technologies**. Based on a detailed analysis of the goals and needs of a given organization, we create dedicated systems and applications that let businesses grow.<br>
Our team is fluent in **Polish, English, German and, French**. That is why our cooperation with clients from all over the world is smooth.

**Some numbers from BitBag regarding Sylius:**
- 50+ **experts** including consultants, UI/UX designers, Sylius trained front-end and back-end developers,
- 120+ projects **delivered** on top of Sylius,
- 25+ **countries** of BitBag’s customers,
- 4+ **years** in the Sylius ecosystem.

**Our services:**
- Business audit/Consulting in the field of **strategy** development,
- Data/shop **migration**,
- Headless **eCommerce**,
- Personalized **software** development,
- **Project** maintenance and long term support,
- Technical **support**.

**Key clients:** Mollie, Guave, P24, Folkstar, i-LUNCH, Elvi Project, WestCoast Gifts.

---

If you need some help with Sylius development, don't be hesitated to contact us directly. You can fill the form on [this site](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=plugins_blacklist) or send us an e-mail at hello@bitbag.io!

---

[![](https://bitbag.io/wp-content/uploads/2021/08/sylius-badges-transparent-wide.png)](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=plugins_blacklist)

## Community

---- 

For online communication, we invite you to chat with us & other users on [Sylius Slack](https://sylius-devs.slack.com/).

# Demo Sylius Shop

---

We created a demo app with some useful use-cases of plugins!
Visit [sylius-demo.bitbag.io](https://sylius-demo.bitbag.io/) to take a look at it. The admin can be accessed under
[sylius-demo.bitbag.io/admin/login](https://sylius-demo.bitbag.io/admin/login) link and `bitbag: bitbag` credentials.
Plugins that we have used in the demo:

| BitBag's Plugin | GitHub | Sylius' Store|
| ------ | ------ | ------|
| ACL Plugin | *Private. Available after the purchasing.*| https://plugins.sylius.com/plugin/access-control-layer-plugin/|
| Braintree Plugin | https://github.com/BitBagCommerce/SyliusBraintreePlugin |https://plugins.sylius.com/plugin/braintree-plugin/|
| CMS Plugin | https://github.com/BitBagCommerce/SyliusCmsPlugin | https://plugins.sylius.com/plugin/cmsplugin/|
| Elasticsearch Plugin | https://github.com/BitBagCommerce/SyliusElasticsearchPlugin | https://plugins.sylius.com/plugin/2004/|
| Mailchimp Plugin | https://github.com/BitBagCommerce/SyliusMailChimpPlugin | https://plugins.sylius.com/plugin/mailchimp/ |
| Multisafepay Plugin | https://github.com/BitBagCommerce/SyliusMultiSafepayPlugin |
| Wishlist Plugin | https://github.com/BitBagCommerce/SyliusWishlistPlugin | https://plugins.sylius.com/plugin/wishlist-plugin/|
| **Sylius' Plugin** | **GitHub** | **Sylius' Store** |
| Admin Order Creation Plugin | https://github.com/Sylius/AdminOrderCreationPlugin | https://plugins.sylius.com/plugin/admin-order-creation-plugin/ |
| Invoicing Plugin | https://github.com/Sylius/InvoicingPlugin | https://plugins.sylius.com/plugin/invoicing-plugin/ |
| Refund Plugin | https://github.com/Sylius/RefundPlugin | https://plugins.sylius.com/plugin/refund-plugin/ |

**If you need an overview of Sylius' capabilities, schedule a consultation with our expert.**

[![](https://bitbag.io/wp-content/uploads/2020/10/button_free_consulatation-1.png)](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=plugins_blacklist)

## Additional resources for developers

---
To learn more about our contribution workflow and more, we encourage you to use the following resources:
* [Sylius Documentation](https://docs.sylius.com/en/latest/)
* [Sylius Contribution Guide](https://docs.sylius.com/en/latest/contributing/)
* [Sylius Online Course](https://sylius.com/online-course/)

## License

---

This plugin's source code is completely free and released under the terms of the MIT license.

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen.)

## Contact

---
If you want to contact us, the best way is to fill the form on [our website](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=plugins_blacklist) or send us an e-mail to hello@bitbag.io with your question(s). We guarantee that we answer as soon as we can!

[![](https://bitbag.io/wp-content/uploads/2021/08/badges-bitbag.png)](https://bitbag.io/contact-us/?utm_source=github&utm_medium=referral&utm_campaign=plugins_blacklist)
