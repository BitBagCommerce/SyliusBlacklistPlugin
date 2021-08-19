<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

namespace spec\BitBag\SyliusBlacklistPlugin\Converter;

use BitBag\SyliusBlacklistPlugin\Converter\FraudSuspicionCommonModelConverter;
use BitBag\SyliusBlacklistPlugin\Converter\FraudSuspicionCommonModelConverterInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Factory\FraudSuspicionCommonModelFactoryInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

final class FraudSuspicionCommonModelConverterSpec extends ObjectBehavior
{
    function let(FraudSuspicionCommonModelFactoryInterface $fraudSuspicionCommonModelFactory)
    {
        $this->beConstructedWith($fraudSuspicionCommonModelFactory);
    }
    function it_is_initializable(): void
    {
        $this->shouldHaveType(FraudSuspicionCommonModelConverter::class);
    }

    function it_implements_automatic_blacklisting_rule_checker_interface(): void
    {
        $this->shouldHaveType(FraudSuspicionCommonModelConverterInterface::class);
    }

    function it_converts_fraud_suspicion_to_model(
        FraudSuspicionCommonModelFactoryInterface $fraudSuspicionCommonModelFactory,
        FraudSuspicionInterface $fraudSuspicion,
        CustomerInterface $customer
    ): void {
        $fraudSuspicionCommonModelFactory->createNew()->willReturn(new FraudSuspicionCommonModel());
        $fraudSuspicion->getOrder()->willReturn(null);
        $fraudSuspicion->getCustomer()->willReturn($customer);
        $fraudSuspicion->getCompany()->willReturn(null);
        $fraudSuspicion->getFirstName()->willReturn('John');
        $fraudSuspicion->getLastName()->willReturn('Doe');
        $fraudSuspicion->getEmail()->willReturn('john_doe@example.com');
        $fraudSuspicion->getPhoneNumber()->willReturn(null);
        $fraudSuspicion->getCity()->willReturn('Warsaw');
        $fraudSuspicion->getStreet()->willReturn('Aleje Jerozolimskie 23');
        $fraudSuspicion->getProvince()->willReturn(null);
        $fraudSuspicion->getPostcode()->willReturn('00-00');
        $fraudSuspicion->getCountry()->willReturn('PL');
        $fraudSuspicion->getCustomerIp()->willReturn('127.0.0.1');

        $fraudSuspicionCommonModelFactory->createNew()->shouldBeCalled();
        $fraudSuspicion->getOrder()->shouldBeCalled();
        $fraudSuspicion->getCustomer()->shouldBeCalled();
        $fraudSuspicion->getCompany()->shouldBeCalled();
        $fraudSuspicion->getFirstName()->shouldBeCalled();
        $fraudSuspicion->getLastName()->shouldBeCalled();
        $fraudSuspicion->getEmail()->shouldBeCalled();
        $fraudSuspicion->getPhoneNumber()->shouldBeCalled();
        $fraudSuspicion->getCity()->shouldBeCalled();
        $fraudSuspicion->getStreet()->shouldBeCalled();
        $fraudSuspicion->getProvince()->shouldBeCalled();
        $fraudSuspicion->getPostcode()->shouldBeCalled();
        $fraudSuspicion->getCountry()->shouldBeCalled();
        $fraudSuspicion->getCustomerIp()->shouldBeCalled();

        $model = $this->convertFraudSuspicionObject($fraudSuspicion);

        $model->getFirstName()->shouldReturn('John');
        $model->getLastName()->shouldReturn('Doe');
        $model->getEmail()->shouldReturn('john_doe@example.com');
        $model->getCity()->shouldReturn('Warsaw');
    }
}
