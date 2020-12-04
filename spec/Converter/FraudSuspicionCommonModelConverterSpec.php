<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Converter;

use BitBag\SyliusBlacklistPlugin\Converter\FraudSuspicionCommonModelConverter;
use BitBag\SyliusBlacklistPlugin\Converter\FraudSuspicionCommonModelConverterInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

final class FraudSuspicionCommonModelConverterSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(FraudSuspicionCommonModelConverter::class);
    }

    function it_implements_automatic_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(FraudSuspicionCommonModelConverterInterface::class);
    }

    function it_converts_fraud_suspicion_to_model(FraudSuspicionInterface $fraudSuspicion, CustomerInterface $customer): void
    {
        $fraudSuspicion->getOrder()->shouldBeCalled()->willReturn(null);
        $fraudSuspicion->getCustomer()->shouldBeCalled()->willReturn($customer);
        $fraudSuspicion->getCompany()->shouldBeCalled()->willReturn(null);
        $fraudSuspicion->getFirstName()->shouldBeCalled()->willReturn('John');
        $fraudSuspicion->getLastName()->shouldBeCalled()->willReturn('Doe');
        $fraudSuspicion->getEmail()->shouldBeCalled()->willReturn('john_doe@example.com');
        $fraudSuspicion->getPhoneNumber()->shouldBeCalled()->willReturn(null);
        $fraudSuspicion->getCity()->shouldBeCalled()->willReturn('Warsaw');
        $fraudSuspicion->getStreet()->shouldBeCalled()->willReturn('Aleje Jerozolimskie 23');
        $fraudSuspicion->getProvince()->shouldBeCalled()->willReturn(null);
//        $fraudSuspicion->getPostcode()->shouldBeCalled()->willReturn('00-00');
        $fraudSuspicion->getCountry()->shouldBeCalled()->willReturn('PL');

        $model = $this->convertFraudSuspicionObject($fraudSuspicion);

        $model->getFirstName()->shouldReturn('John');
        $model->getLastName()->shouldReturn('Doe');
        $model->getEmail()->shouldReturn('john_doe@example.com');
        $model->getCity()->shouldReturn('Warsaw');
    }

    function it_converts_order_with_address_type_to_model(OrderInterface $order, CustomerInterface $customer, AddressInterface $address): void
    {
        $model = $this->convertOrderObject($order, FraudSuspicionInterface::BILLING_ADDRESS_TYPE);
        $order->getBillingAddress()->shouldBeCalled()->willReturn($address);

        $order->getCustomer()->shouldBeCalled()->willReturn($customer);
        $address->getCompany()->shouldBeCalled()->willReturn(null);
        $address->getFirstName()->shouldBeCalled()->willReturn('John');
        $address->getLastName()->shouldBeCalled()->willReturn('Doe');
        $customer->getEmail()->shouldBeCalled()->willReturn('john_doe@example.com');
        $address->getPhoneNumber()->shouldBeCalled()->willReturn(null);
        $address->getCity()->shouldBeCalled()->willReturn('Warsaw');
        $address->getStreet()->shouldBeCalled()->willReturn('Aleje Jerozolimskie 23');
        $address->getProvinceName()->shouldBeCalled()->willReturn(null);
        $address->getPostcode()->shouldBeCalled()->willReturn('00-00');
        $address->getCountryCode()->shouldBeCalled()->willReturn('PL');


        $model->getFirstName()->shouldReturn('John');
        $model->getLastName()->shouldReturn('Doe');
        $model->getEmail()->shouldReturn('john_doe@example.com');
        $model->getCity()->shouldReturn('Warsaw');
    }
}
