<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Model;

use BitBag\SyliusBlacklistPlugin\Entity\Customer\CustomerInterface;
use Doctrine\ORM\Mapping as ORM;

trait CustomerTrait
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", name="fraud_status")
     */
    private $fraudStatus = CustomerInterface::FRAUD_STATUS_NEUTRAL;

    public function getFraudStatus(): string
    {
        return $this->fraudStatus;
    }

    public function setFraudStatus(string $fraudStatus)
    {
        $this->fraudStatus = $fraudStatus;
    }
}