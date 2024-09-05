# Attribute-mapping

Check the mapping settings in `config/packages/doctrine.yaml` and, if necessary, change them accordingly.
```yaml
doctrine:
    ...
    orm:
        ...
        mappings:
            App:
                ...
                type: attribute
```

Extend entities with parameters and methods using attributes and traits:

- `Customer` entity

```php
<?php
// src/Entity/Customer/Customer.php

declare(strict_types=1);

namespace App\Entity\Customer;

use BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudStatusTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Customer as BaseCustomer;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_customer")
 */
#[ORM\Entity]
#[ORM\Table(name: 'sylius_customer')]
class Customer extends BaseCustomer implements CustomerInterface
{
    use FraudStatusTrait;

    #[ORM\Column(type: 'string', nullable: false)]
    protected $fraudStatus = FraudStatusInterface::FRAUD_STATUS_NEUTRAL;
}
```
