<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
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