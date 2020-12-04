<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Factory;

use BitBag\SyliusBlacklistPlugin\Factory\FraudSuspicionFactory;
use BitBag\SyliusBlacklistPlugin\Factory\FraudSuspicionFactoryInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

final class FraudSuspicionFactorySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(FraudSuspicionFactory::class);
    }

    function it_implements_blacklisting_rule_interface(): void
    {
        $this->shouldHaveType(FraudSuspicionFactoryInterface::class);
    }

    function it_creates_empty_fraud_suspicion_object(): void
    {
        $this->createNew()->getId()->shouldReturn(null);
    }

    function it_creates_fraud_suspicion_objet_from_order(OrderInterface $order, CustomerInterface $customer, AddressInterface $address): void
    {
        $order->getCustomer()->shouldBeCalled()->willReturn($customer);
        $order->getCustomerIp()->shouldBeCalled()->willReturn('192.168.10.12');
        $order->getBillingAddress()->shouldBeCalled()->willReturn($address);
        $address->getFirstName()->shouldBeCalled()->willReturn('John');
        $address->getLastName()->shouldBeCalled()->willReturn('Doe');
        $customer->getEmail()->shouldBeCalled()->willReturn('john_doe@example.com');
        $address->getCountryCode()->shouldBeCalled()->willReturn('PL');
        $address->getProvinceName()->shouldBeCalled()->willReturn(null);
        $address->getCompany()->shouldBeCalled()->willReturn(null);
        $address->getPostcode()->shouldBeCalled()->willReturn('00-000');
        $address->getCity()->shouldBeCalled()->willReturn('Warsaw');
        $address->getStreet()->shouldBeCalled()->willReturn('Aleje Jerozolimskie 23');


        $model = $this->createForOrder($order);

        $model->getFirstName()->shouldReturn('John');
        $model->getLastName()->shouldReturn('Doe');
        $model->getEmail()->shouldReturn('john_doe@example.com');
        $model->getCountry()->shouldReturn('PL');
        $model->getCity()->shouldReturn('Warsaw');
    }
}
