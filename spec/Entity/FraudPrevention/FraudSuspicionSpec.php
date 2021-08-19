<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

namespace spec\BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicion;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use PhpSpec\ObjectBehavior;

final class FraudSuspicionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(FraudSuspicion::class);
    }

    function it_implements_wishlist_interface(): void
    {
        $this->shouldHaveType(FraudSuspicionInterface::class);
    }

    function it_has_null_id_by_default(): void
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_order_by_default(): void
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
        $this->getProvince()->shouldReturn(null);
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

    function it_has_no_address_type_by_default(): void
    {
        $this->getAddressType()->shouldReturn(null);
    }

    function it_has_no_comment_by_default(): void
    {
        $this->getComment()->shouldReturn(null);
    }

    function it_gets_first_name(): void
    {
        $this->setFirstName('John');

        $this->getFirstName()->shouldReturn('John');
    }

    function it_gets_email(): void
    {
        $this->setEmail('john_doe@example.com');

        $this->getEmail()->shouldReturn('john_doe@example.com');
    }

    function it_gets_address_type(): void
    {
        $this->setAddressType(FraudSuspicionInterface::BILLING_ADDRESS_TYPE);

        $this->getAddressType()->shouldReturn(FraudSuspicionInterface::BILLING_ADDRESS_TYPE);
    }
}
