<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Converter;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicion;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Exception\WrongAddressTypeException;
use BitBag\SyliusBlacklistPlugin\Factory\FraudSuspicionCommonModelFactoryInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Order\Model\OrderInterface;

class FraudSuspicionCommonModelConverter implements FraudSuspicionCommonModelConverterInterface
{
    private FraudSuspicionCommonModelFactoryInterface $fraudSuspicionCommonModelFactory;

    public function __construct(FraudSuspicionCommonModelFactoryInterface $fraudSuspicionCommonModelFactory)
    {
        $this->fraudSuspicionCommonModelFactory = $fraudSuspicionCommonModelFactory;
    }

    public function convertFraudSuspicionObject(FraudSuspicionInterface $fraudSuspicion): FraudSuspicionCommonModelInterface
    {
        return $this->populateFraudSuspicionCommonModel(
            $this->fraudSuspicionCommonModelFactory->createNew(),
            [
                'order' => $fraudSuspicion->getOrder(),
                'customer' => $fraudSuspicion->getCustomer(),
                'company' => $fraudSuspicion->getCompany(),
                'firstName' => $fraudSuspicion->getFirstName(),
                'lastName' => $fraudSuspicion->getLastName(),
                'email' => $fraudSuspicion->getEmail(),
                'phoneNumber' => $fraudSuspicion->getPhoneNumber(),
                'street' => $fraudSuspicion->getStreet(),
                'city' => $fraudSuspicion->getCity(),
                'province' => $fraudSuspicion->getProvince(),
                'country' => $fraudSuspicion->getCountry(),
                'postcode' => $fraudSuspicion->getPostcode(),
                'customerIp' => $fraudSuspicion->getCustomerIp(),
            ]
        );
    }

    public function convertOrderObject(OrderInterface $order, string $addressType): FraudSuspicionCommonModelInterface
    {
        $address = $this->getAddressFromOrder($order, $addressType);

        return $this->populateFraudSuspicionCommonModel(
            $this->fraudSuspicionCommonModelFactory->createNew(),
            [
                'order' => $order,
                'customer' => $order->getCustomer(),
                'company' => $address->getCompany(),
                'firstName' => $address->getFirstName(),
                'lastName' => $address->getLastName(),
                'email' => $order->getCustomer()?->getEmail(),
                'phoneNumber' => $address->getPhoneNumber(),
                'street' => $address->getStreet(),
                'city' => $address->getCity(),
                'province' => $address->getProvinceName(),
                'country' => $address->getCountryCode(),
                'postcode' => $address->getPostcode(),
                'customerIp' => $order->getCustomerIp(),
            ]
        );
    }

    private function getAddressFromOrder(OrderInterface $order, string $addressType): AddressInterface
    {
        return match ($addressType) {
            FraudSuspicion::BILLING_ADDRESS_TYPE => $order->getBillingAddress(),
            FraudSuspicion::SHIPPING_ADDRESS_TYPE => $order->getShippingAddress(),
            default => throw new WrongAddressTypeException('Wrong address type!'),
        };
    }

    private function populateFraudSuspicionCommonModel(
        FraudSuspicionCommonModelInterface $model,
        array $data
    ): FraudSuspicionCommonModelInterface {
        $model->setOrder($data['order']);
        $model->setCustomer($data['customer']);
        $model->setCompany($data['company']);
        $model->setFirstName($data['firstName']);
        $model->setLastName($data['lastName']);
        $model->setEmail($data['email']);
        $model->setPhoneNumber($data['phoneNumber']);
        $model->setStreet($data['street']);
        $model->setCity($data['city']);
        $model->setProvince($data['province']);
        $model->setCountry($data['country']);
        $model->setPostcode($data['postcode']);
        $model->setCustomerIp($data['customerIp']);

        return $model;
    }
}
