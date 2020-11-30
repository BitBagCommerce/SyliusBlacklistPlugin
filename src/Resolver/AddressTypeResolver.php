<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Resolver;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicion;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use Sylius\Component\Core\Model\AddressInterface;

class AddressTypeResolver implements AddressTypeResolverInterface
{
    public function resolveAndUpdateFraudSuspicion(FraudSuspicionInterface $fraudSuspicion): void
    {
        $address = $this->resolve($fraudSuspicion);

        $fraudSuspicion->setFirstName($address->getFirstName());
        $fraudSuspicion->setLastName($address->getLastName());
        $fraudSuspicion->setCompany($address->getCompany());
        $fraudSuspicion->setCity($address->getCity());
        $fraudSuspicion->setProvince($address->getProvinceName());
        $fraudSuspicion->setCountry($address->getCountryCode());
        $fraudSuspicion->setPhoneNumber($address->getPhoneNumber());
    }

    private function resolve(FraudSuspicionInterface $fraudSuspicion): AddressInterface
    {
        switch ($fraudSuspicion->getAddressType()) {
            case FraudSuspicion::BILLING_ADDRESS_TYPE:
                return $fraudSuspicion->getOrder()->getBillingAddress();
            case FraudSuspicion::SHIPPING_ADDRESS_TYPE:
                return $fraudSuspicion->getOrder()->getShippingAddress();
            default:
                throw new \Exception('Wrong address type!');
        }
    }
}