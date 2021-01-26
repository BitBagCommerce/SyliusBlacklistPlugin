<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Validator\Constraints\AutomaticBlacklistingConfiguration;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\AutomaticBlacklistingConfigurationInterface;
use BitBag\SyliusBlacklistPlugin\Repository\BlacklistingRuleRepositoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Webmozart\Assert\Assert;

class AddFraudSuspicionByAutomaticBlacklistingConfigurationValidator extends ConstraintValidator
{
    /** @var BlacklistingRuleRepositoryInterface */
    private $blacklistingRuleRepository;

    /** @var ChannelContextInterface */
    private $channelContext;

    public function __construct(BlacklistingRuleRepositoryInterface $blacklistingRuleRepository, ChannelContextInterface $channelContext)
    {
        $this->blacklistingRuleRepository = $blacklistingRuleRepository;
        $this->channelContext = $channelContext;
    }

    public function validate($automaticBlacklistingConfiguration, Constraint $constraint): void
    {
        Assert::isInstanceOf($automaticBlacklistingConfiguration, AutomaticBlacklistingConfigurationInterface::class);

        if ($automaticBlacklistingConfiguration->isAddFraudSuspicionRowAfterExceedLimit()) {
            $channel = $this->channelContext->getChannel();

            $blacklistingRules = $this->blacklistingRuleRepository->findActiveByChannel($channel);

            if (\count($blacklistingRules) === 0) {
                $this->context->buildViolation($constraint->message)->addViolation();
            }
        }
    }
}
