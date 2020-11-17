<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class BitBagSyliusBlacklistPlugin extends Bundle
{
    use SyliusPluginTrait;
}
