<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class AutomaticBlacklistingConfigurationLabelsExtension extends AbstractExtension
{
    /**
     * @param array<string, string> $ruleTypes
     */
    public function __construct(
        private array $ruleTypes,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('automatic_blacklisting_configuration_get_rule_label', [$this, 'getRuleLabel']),
        ];
    }

    public function getRuleLabel(string $type): string
    {
        return $this->ruleTypes[$type] ?? '';
    }
}
