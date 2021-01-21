<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusBlacklistPlugin\Validator\Constraints\Checkout;

use BitBag\SyliusBlacklistPlugin\Converter\FraudSuspicionCommonModelConverterInterface;
use BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Model\FraudSuspicionCommonModelInterface;
use BitBag\SyliusBlacklistPlugin\Processor\AutomaticBlacklistingRulesProcessorInterface;
use BitBag\SyliusBlacklistPlugin\Resolver\SuspiciousOrderResolverInterface;
use BitBag\SyliusBlacklistPlugin\Validator\Constraints\Checkout\CheckoutAddressType;
use BitBag\SyliusBlacklistPlugin\Validator\Constraints\Checkout\CheckoutAddressTypeValidator;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Component\Validator\ConstraintValidator;
use Tests\BitBag\SyliusBlacklistPlugin\Entity\CustomerInterface;

final class CheckoutAddressTypeValidatorSpec extends ObjectBehavior
{
    function let(
        SuspiciousOrderResolverInterface $suspiciousOrderResolver,
        AutomaticBlacklistingRulesProcessorInterface $automaticBlacklistingRulesProcessor,
        FraudSuspicionCommonModelConverterInterface $fraudSuspicionCommonModelConverter
    ): void {
        $this->beConstructedWith($suspiciousOrderResolver, $automaticBlacklistingRulesProcessor, $fraudSuspicionCommonModelConverter);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(CheckoutAddressTypeValidator::class);
    }

    function it_extends_constraint_validator_class(): void
    {
        $this->shouldHaveType(ConstraintValidator::class);
    }

    function it_validates(
        OrderInterface $order,
        CustomerInterface $customer,
        SuspiciousOrderResolverInterface $suspiciousOrderResolver,
        AutomaticBlacklistingRulesProcessorInterface $automaticBlacklistingRulesProcessor,
        FraudSuspicionCommonModelConverterInterface $fraudSuspicionCommonModelConverter,
        FraudSuspicionCommonModelInterface $fraudSuspicionCommonModel
    ): void {
        $checkoutAddressTypeConstraint = new CheckoutAddressType();

        $order->getCustomer()->willReturn($customer);
        $customer->getFraudStatus()->willReturn(FraudStatusInterface::FRAUD_STATUS_NEUTRAL);
        $customer->getFraudStatus()->willReturn(FraudStatusInterface::FRAUD_STATUS_NEUTRAL);
        $automaticBlacklistingRulesProcessor->process($order)->willReturn(false);
        $fraudSuspicionCommonModelConverter->convertOrderObject($order, FraudSuspicionInterface::BILLING_ADDRESS_TYPE)->willReturn($fraudSuspicionCommonModel);
        $fraudSuspicionCommonModelConverter->convertOrderObject($order, FraudSuspicionInterface::SHIPPING_ADDRESS_TYPE)->willReturn($fraudSuspicionCommonModel);
        $suspiciousOrderResolver->resolve($fraudSuspicionCommonModel)->willReturn(false);
        $suspiciousOrderResolver->resolve($fraudSuspicionCommonModel)->willReturn(false);

        $order->getCustomer()->shouldBeCalled();
        $customer->getFraudStatus()->shouldBeCalled();
        $customer->getFraudStatus()->shouldBeCalled();
        $automaticBlacklistingRulesProcessor->process($order)->shouldBeCalled();
        $fraudSuspicionCommonModelConverter->convertOrderObject($order, FraudSuspicionInterface::BILLING_ADDRESS_TYPE)->shouldBeCalled();
        $fraudSuspicionCommonModelConverter->convertOrderObject($order, FraudSuspicionInterface::SHIPPING_ADDRESS_TYPE)->shouldBeCalled();
        $suspiciousOrderResolver->resolve($fraudSuspicionCommonModel)->shouldBeCalled();
        $suspiciousOrderResolver->resolve($fraudSuspicionCommonModel)->shouldBeCalled();

        $this->validate($order, $checkoutAddressTypeConstraint);
    }

    function it_does_not_block_if_customer_is_whitelisted(OrderInterface $order, CustomerInterface $customer): void
    {
        $checkoutAddressTypeConstraint = new CheckoutAddressType();

        $order->getCustomer()->willReturn($customer);
        $customer->getFraudStatus()->willReturn(FraudStatusInterface::FRAUD_STATUS_WHITELISTED);

        $order->getCustomer()->shouldBeCalled();
        $customer->getFraudStatus()->shouldBeCalled();

        $this->validate($order, $checkoutAddressTypeConstraint);
    }
}
