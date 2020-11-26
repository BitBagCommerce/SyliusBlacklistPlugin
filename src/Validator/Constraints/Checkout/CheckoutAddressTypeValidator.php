<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Validator\Constraints\Checkout;

use BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface;
use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\FraudSuspicionInterface;
use BitBag\SyliusBlacklistPlugin\Resolver\SuspiciousOrderResolverInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Webmozart\Assert\Assert;

class CheckoutAddressTypeValidator extends ConstraintValidator
{
    /** @var SuspiciousOrderResolverInterface */
    private $suspiciousOrderResolver;

    public function __construct(SuspiciousOrderResolverInterface $suspiciousOrderResolver)
    {
        $this->suspiciousOrderResolver = $suspiciousOrderResolver;
    }

    public function validate($order, Constraint $constraint): void
    {
        /** @var OrderInterface $order */
        Assert::isInstanceOf($order, OrderInterface::class);

        /** @var CustomerInterface $customer */
        $customer = $order->getCustomer();

        if ($customer->getFraudStatus() === FraudStatusInterface::FRAUD_STATUS_BLACKLISTED) {
            $this->context->buildViolation($constraint->message)->setTranslationDomain('validators')->addViolation();
            return;
        }

        if ($this->suspiciousOrderResolver->resolve($order, FraudSuspicionInterface::BILLING_ADDRESS_TYPE)) {
            $this->context->buildViolation($constraint->message)->setTranslationDomain('validators')->addViolation();
            return;
        }

        if ($this->suspiciousOrderResolver->resolve($order, FraudSuspicionInterface::SHIPPING_ADDRESS_TYPE)) {
            $this->context->buildViolation($constraint->message)->setTranslationDomain('validators')->addViolation();
            return;
        }
    }
}
