<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Model;

use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModel;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use PhpSpec\ObjectBehavior;

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
}
