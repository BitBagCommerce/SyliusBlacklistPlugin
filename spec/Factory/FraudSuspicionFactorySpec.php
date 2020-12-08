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
        $order->getCustomer()->willReturn($customer);
        $order->getCustomerIp()->willReturn('192.168.10.12');
        $order->getBillingAddress()->willReturn($address);
        $address->getFirstName()->willReturn('John');
        $address->getLastName()->willReturn('Doe');
        $customer->getEmail()->willReturn('john_doe@example.com');
        $address->getCountryCode()->willReturn('PL');
        $address->getProvinceName()->willReturn(null);
        $address->getCompany()->willReturn(null);
        $address->getPostcode()->willReturn('00-000');
        $address->getCity()->willReturn('Warsaw');
        $address->getStreet()->willReturn('Aleje Jerozolimskie 23');

        $order->getCustomer()->shouldBeCalled();
        $order->getCustomerIp()->shouldBeCalled();
        $order->getBillingAddress()->shouldBeCalled();
        $address->getFirstName()->shouldBeCalled();
        $address->getLastName()->shouldBeCalled();
        $customer->getEmail()->shouldBeCalled();
        $address->getCountryCode()->shouldBeCalled();
        $address->getProvinceName()->shouldBeCalled();
        $address->getCompany()->shouldBeCalled();
        $address->getPostcode()->shouldBeCalled();
        $address->getCity()->shouldBeCalled();
        $address->getStreet()->shouldBeCalled();

        $model = $this->createForOrder($order);

        $model->getFirstName()->shouldReturn('John');
        $model->getLastName()->shouldReturn('Doe');
        $model->getEmail()->shouldReturn('john_doe@example.com');
        $model->getCountry()->shouldReturn('PL');
        $model->getCity()->shouldReturn('Warsaw');
    }
}
