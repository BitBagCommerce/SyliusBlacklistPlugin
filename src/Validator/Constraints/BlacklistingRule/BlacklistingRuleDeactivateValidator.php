<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Validator\Constraints\BlacklistingRule;

use BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention\BlacklistingRuleInterface;
use BitBag\SyliusBlacklistPlugin\Repository\AutomaticBlacklistingConfigurationRepositoryInterface;
use BitBag\SyliusBlacklistPlugin\Repository\BlacklistingRuleRepositoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Webmozart\Assert\Assert;

class BlacklistingRuleDeactivateValidator extends ConstraintValidator
{
    /** @var AutomaticBlacklistingConfigurationRepositoryInterface */
    private $automaticBlacklistingConfigurationRepository;

    /** @var BlacklistingRuleRepositoryInterface */
    private $blacklistingRuleRepository;

    /** @var ChannelContextInterface */
    private $channelContext;

    public function __construct(
        AutomaticBlacklistingConfigurationRepositoryInterface $automaticBlacklistingConfigurationRepository,
        BlacklistingRuleRepositoryInterface $blacklistingRuleRepository,
        ChannelContextInterface $channelContext
    ) {
        $this->automaticBlacklistingConfigurationRepository = $automaticBlacklistingConfigurationRepository;
        $this->blacklistingRuleRepository = $blacklistingRuleRepository;
        $this->channelContext = $channelContext;
    }

    public function validate($enabled, Constraint $constraint): void
    {
        if (!$enabled) {
            $channel = $this->channelContext->getChannel();

            $activeBlacklistingRules = $this->blacklistingRuleRepository->findActiveByChannel($channel);
            $automaticBlacklistingConfigurations = $this->automaticBlacklistingConfigurationRepository->findActiveByChannelWithAddFraudSuspicion($channel);

            $countActiveBlacklistingRules = \count($activeBlacklistingRules);
            $countAutomaticBlacklistingConfigurations = \count($automaticBlacklistingConfigurations);

            if ($countAutomaticBlacklistingConfigurations > 0 && $countActiveBlacklistingRules <= 1) {
                $this->context->buildViolation($constraint->message)->addViolation();
            }
        }
    }
}
