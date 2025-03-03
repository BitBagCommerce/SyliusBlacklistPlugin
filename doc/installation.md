# Installation

## Overview:
GENERAL
- [Requirements](#requirements)
- [Composer](#composer)
- [Basic configuration](#basic-configuration)
--- 
BACKEND
- [Entities](#entities)
    - [Attribute mapping](#attribute-mapping)
    - [XML mapping](#xml-mapping)
- [Repositories](#repositories)
---
FRONTEND
- [Templates](#templates)
---
ADDITIONAL
- [Tests](#tests)
- [Known Issues](#known-issues)
---

## Requirements:
We work on stable, supported and up-to-date versions of packages. We recommend you to do the same.

| Package       | Version  |
|---------------|----------|
| PHP           | \>=8.2   |
| sylius/sylius | 2.0.x    |
| MySQL         | \>= 5.7  |
| NodeJS        | \>= 18.x |

## Composer:
```bash
composer require bitbag/blacklist-plugin --no-scripts
```

## Basic configuration:
Add plugin dependencies to your `config/bundles.php` file:

```php
# config/bundles.php

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
    - { resource: "@BitBagSyliusBlacklistPlugin/config/config.yaml" }
```

Add routing to your `config/routes.yaml` file:
```yaml
# config/routes.yaml

bitbag_sylius_blacklist_plugin:
    resource: "@BitBagSyliusBlacklistPlugin/config/routing.yaml"
```

Override Customer grid in `config/packages/_sylius_grid.yml` file:
```yaml
# config/packages/_sylius_grid.yml

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

Override twig configuration in `config/packages/twig.yml` file:
```yaml
# config/packages/twig.yaml
...

twig:
    paths: ['%kernel.project_dir%/templates']
    debug: '%kernel.debug%'
    strict_variables: '%kernel.debug%'
    form_themes:
        - '@BitBagSyliusBlacklistPlugin/Form/theme.html.twig'
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

## Entities
You can implement entity configuration by using both xml-mapping and attribute-mapping. Depending on your preference, choose either one or the other:
### Attribute mapping
- [Attribute mapping configuration](installation/attribute-mapping.md)
### XML mapping
- [XML mapping configuration](installation/xml-mapping.md)

**Note:** If you are running it on production, add the `-e prod` flag to this command.

## Repositories
Add repository with following trait:
```php
<?php
// src/Repository/CustomerRepository.php

declare(strict_types=1);

namespace App\Repository;

use BitBag\SyliusBlacklistPlugin\Repository\CustomerRepositoryTrait;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\CustomerRepository as BaseCustomerRepository;

class CustomerRepository extends BaseCustomerRepository
{
    use CustomerRepositoryTrait;
}
```

Override `config/packages/_sylius.yaml` configuration:
```yaml
# config/packages/_sylius.yaml
...

sylius_customer:
    resources:
        customer:
            classes:
                ...
                repository: App\Repository\CustomerRepository
```

### Update your database

As the plugin doesn't have their own migration script, please generate your own migration file depending on database changes:

```bash
bin/console doctrine:migrations:diff
bin/console doctrine:migrations:migrate
```

Alternative, you can use the schema tool to update your database without migrations:

```bash
bin/console doctrine:schema:update --dump-sql # Please review database queries before running them!
bin/console doctrine:schema:update --force    # This command RUNS THE QUERIES.
```

### Clear application cache by using command:
```bash
bin/console cache:clear
```
**Note:** If you are running it on production, add the `-e prod` flag to this command.

## Tests
To run the tests, execute the commands:
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

## Known issues
### Translations not displaying correctly
For incorrectly displayed translations, execute the command:
```bash
bin/console cache:clear
```
