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
    /** @var FraudSuspicionCommonModelFactoryInterface */
    private $fraudSuspicionCommonModelFactory;

    public function __construct(FraudSuspicionCommonModelFactoryInterface $fraudSuspicionCommonModelFactory)
    {
        $this->fraudSuspicionCommonModelFactory = $fraudSuspicionCommonModelFactory;
    }

    public function convertFraudSuspicionObject(FraudSuspicionInterface $fraudSuspicion): FraudSuspicionCommonModelInterface
    {
        $fraudSuspicionCommonModel = $this->fraudSuspicionCommonModelFactory->createNew();

        $fraudSuspicionCommonModel->setOrder($fraudSuspicion->getOrder());
        $fraudSuspicionCommonModel->setCustomer($fraudSuspicion->getCustomer());
        $fraudSuspicionCommonModel->setCompany($fraudSuspicion->getCompany());
        $fraudSuspicionCommonModel->setFirstName($fraudSuspicion->getFirstName());
        $fraudSuspicionCommonModel->setLastName($fraudSuspicion->getLastName());
        $fraudSuspicionCommonModel->setEmail($fraudSuspicion->getEmail());
        $fraudSuspicionCommonModel->setPhoneNumber($fraudSuspicion->getPhoneNumber());
        $fraudSuspicionCommonModel->setCity($fraudSuspicion->getCity());
        $fraudSuspicionCommonModel->setPostcode($fraudSuspicion->getPostcode());
        $fraudSuspicionCommonModel->setStreet($fraudSuspicion->getStreet());
        $fraudSuspicionCommonModel->setProvince($fraudSuspicion->getProvince());
        $fraudSuspicionCommonModel->setCountry($fraudSuspicion->getCountry());

        return $fraudSuspicionCommonModel;
    }

    public function convertOrderObject(OrderInterface $order, string $addressType): FraudSuspicionCommonModelInterface
    {
        $address = $this->getAddressFromOrder($order, $addressType);

        $fraudSuspicionCommonModel = $this->fraudSuspicionCommonModelFactory->createNew();

        $fraudSuspicionCommonModel->setOrder($order);
        $fraudSuspicionCommonModel->setCustomer($order->getCustomer());
        $fraudSuspicionCommonModel->setCompany($address->getCompany());
        $fraudSuspicionCommonModel->setFirstName($address->getFirstName());
        $fraudSuspicionCommonModel->setLastName($address->getLastName());
        $fraudSuspicionCommonModel->setEmail($order->getCustomer()->getEmail());
        $fraudSuspicionCommonModel->setPhoneNumber($address->getPhoneNumber());
        $fraudSuspicionCommonModel->setCity($address->getCity());
        $fraudSuspicionCommonModel->setStreet($address->getStreet());
        $fraudSuspicionCommonModel->setProvince($address->getProvinceName());
        $fraudSuspicionCommonModel->setCountry($address->getCountryCode());
        $fraudSuspicionCommonModel->setCustomerIp($order->getCustomerIp());

        return $fraudSuspicionCommonModel;
    }

    private function getAddressFromOrder(OrderInterface $order, string $addressType): AddressInterface
    {
        switch ($addressType) {
            case FraudSuspicion::BILLING_ADDRESS_TYPE:
                return $order->getBillingAddress();
            case FraudSuspicion::SHIPPING_ADDRESS_TYPE:
                return $order->getShippingAddress();
            default:
                throw new WrongAddressTypeException('Wrong address type!');
        }
    }
}