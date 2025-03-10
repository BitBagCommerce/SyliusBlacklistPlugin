<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Transitions;

class CustomerTransitions
{
    public const GRAPH = 'bitbag_sylius_blacklist_plugin_customer';

    public const TRANSITION_BLACKLISTING_PROCESS = 'blacklisting';

    public const TRANSITION_NEUTRALIZING_PROCESS = 'neutral';

    public const TRANSITION_WHITELISTING_PROCESS = 'whitelisting';
}
