# XML-mapping

Check the mapping settings in `config/packages/doctrine.yaml` and, if necessary, change them accordingly.
```yaml
doctrine:
    ...
    orm:
        ...
        mappings:
            App:
                ...
                type: xml
                dir: '%kernel.project_dir%/src/Resources/config/doctrine'
```

Extend entities with parameters and methods using attributes and traits:

- `Customer` entity:

```php
<?php
// src/Entity/Customer.php

declare(strict_types=1);

namespace App\Entity\Customer;

use BitBag\SyliusBlacklistPlugin\Model\FraudStatusTrait;
use Sylius\Component\Core\Model\Customer as BaseCustomer;

class Customer extends BaseCustomer implements CustomerInterface
{
    use FraudStatusTrait;
}
```

Define new Entity mapping inside `src/Resources/config/doctrine` directory.

- `Customer` entity:

`src/Resources/config/doctrine/Customer.orm.xml`

```xml
<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping
        xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                            http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd"
>
    <entity name="App\Entity\Customer" table="sylius_customer">
        <field name="fraudStatus" column="fraud_status" type="string" />
    </entity>
</doctrine-mapping>
```

Create also interface, which is implemented by `Customer` entity:
```php
<?php
// src/Entity/CustomerInterface.php

namespace App\Entity\Customer;

use BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface;
use Sylius\Component\Core\Model\CustomerInterface as BaseCustomerInterface;

interface CustomerInterface extends BaseCustomerInterface, FraudStatusInterface
{
}
```

Override `config/packages/_sylius.yaml` configuration:
```yaml
# config/_sylius.yaml

sylius_customer:
    resources:
        customer:
            classes:
                model: App\Entity\Customer
```
