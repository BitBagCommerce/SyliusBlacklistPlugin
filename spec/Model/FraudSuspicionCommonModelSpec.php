<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);namespace spec\BitBag\SyliusBlacklistPlugin\Model;

use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

final class FraudSuspicionCommonModelSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(FraudSuspicionCommonModel::class);
    }

    function it_implements_fraud_suspicion_common_model_interface(): void
    {
        $this->shouldHaveType(FraudSuspicionCommonModelInterface::class);
    }

    function it_has_no_order_default(): void
    {
        $this->getOrder()->shouldReturn(null);
    }

    function it_has_no_customer_by_default(): void
    {
        $this->getCustomer()->shouldReturn(null);
    }

    function it_has_no_company_by_default(): void
    {
        $this->getCompany()->shouldReturn(null);
    }

    function it_has_no_first_name_by_default(): void
    {
        $this->getFirstName()->shouldReturn(null);
    }

    function it_has_no_last_name_by_default(): void
    {
        $this->getLastName()->shouldReturn(null);
    }

    function it_has_no_email_by_default(): void
    {
        $this->getEmail()->shouldReturn(null);
    }

    function it_has_no_phone_number_by_default(): void
    {
        $this->getPhoneNumber()->shouldReturn(null);
    }

    function it_has_no_street_by_default(): void
    {
        $this->getStreet()->shouldReturn(null);
    }

    function it_has_no_city_by_default(): void
    {
        $this->getCity()->shouldReturn(null);
    }

    function it_has_no_province_by_default(): void
    {
        $this->getPostcode()->shouldReturn(null);
    }

    function it_has_no_country_by_default(): void
    {
        $this->getCountry()->shouldReturn(null);
    }

    function it_has_no_postcode_by_default(): void
    {
        $this->getPostcode()->shouldReturn(null);
    }

    function it_has_no_customer_ip_by_default(): void
    {
        $this->getCustomerIp()->shouldReturn(null);
    }

    function it_gets_order(OrderInterface $order): void
    {
        $this->setOrder($order);

        $this->getOrder()->shouldReturn($order);
    }

    function it_gets_customer(CustomerInterface $customer): void
    {
        $this->setCustomer($customer);

        $this->getCustomer()->shouldReturn($customer);
    }

    function it_gets_company(): void
    {
        $this->setCompany('Google');

        $this->getCompany()->shouldReturn('Google');
    }

    function it_gets_first_name(): void
    {
        $this->setFirstName('John');

        $this->getFirstName()->shouldReturn('John');
    }

    function it_gets_last_name(): void
    {
        $this->setLastName('Doe');

        $this->getLastName()->shouldReturn('Doe');
    }

    function it_gets_email(): void
    {
        $this->setEmail('john_doe@example.com');

        $this->getEmail()->shouldReturn('john_doe@example.com');
    }

    function it_gets_phone_number(): void
    {
        $this->setPhoneNumber('786524123');

        $this->getPhoneNumber()->shouldReturn('786524123');
    }

    function it_gets_city(): void
    {
        $this->setCity('Warsaw');

        $this->getCity()->shouldReturn('Warsaw');
    }

    function it_gets_province(): void
    {
        $this->setProvince('Mazowieckie');

        $this->getProvince()->shouldReturn('Mazowieckie');
    }

    function it_gets_postcode(): void
    {
        $this->setPostcode('00-000');

        $this->getPostcode()->shouldReturn('00-000');
    }

    function it_gets_street(): void
    {
        $this->setStreet('Groove Street 56');

        $this->getStreet()->shouldReturn('Groove Street 56');
    }
}
