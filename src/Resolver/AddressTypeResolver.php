<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Resolver;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicion;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Exception\WrongAddressTypeException;
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
        $fraudSuspicion->setStreet($address->getStreet());
        $fraudSuspicion->setProvince($address->getProvinceName());
        $fraudSuspicion->setCountry($address->getCountryCode());
        $fraudSuspicion->setPhoneNumber($address->getPhoneNumber());
    }

    public function resolve(FraudSuspicionInterface $fraudSuspicion): AddressInterface
    {
        switch ($fraudSuspicion->getAddressType()) {
            case FraudSuspicion::BILLING_ADDRESS_TYPE:
                return $fraudSuspicion->getOrder()->getBillingAddress();
            case FraudSuspicion::SHIPPING_ADDRESS_TYPE:
                return $fraudSuspicion->getOrder()->getShippingAddress();
            default:
                throw new WrongAddressTypeException('Wrong address type!');
        }
    }
}
