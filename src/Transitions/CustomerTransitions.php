<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Transitions;

final class CustomerTransitions
{
    public const GRAPH = 'bitbag_sylius_blacklist_plugin_customer';

    public const TRANSITION_BLACKLISTING_PROCESS = 'blacklisting';
}
