<?php

declare(strict_types=1);

namespace BitBag\SyliusBlacklistPlugin\Entity\FraudPrevention;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\TimestampableTrait;

class AutomaticBlacklistingConfiguration implements AutomaticBlacklistingConfigurationInterface
{
    use TimestampableTrait;

    /** @var int|null */
    protected $id;

    /** @var string */
    protected $name;

    /**
     * @var Collection|AutomaticBlacklistingRuleInterface[]
     *
     * @psalm-var Collection<array-key, AutomaticBlacklistingRuleInterface>
     */
    protected $rules;

    public function __construct()
    {
        $this->rules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getRules(): Collection
    {
        return $this->rules;
    }

    public function hasRules(): bool
    {
        return !$this->rules->isEmpty();
    }

    public function hasRule(AutomaticBlacklistingRuleInterface $rule): bool
    {
        return $this->rules->contains($rule);
    }

    public function addRule(AutomaticBlacklistingRuleInterface $rule): void
    {
        if (!$this->hasRule($rule)) {
            $rule->setConfiguration($this);
            $this->rules->add($rule);
        }
    }

    public function removeRule(AutomaticBlacklistingRuleInterface $rule): void
    {
        $rule->setConfiguration(null);
        $this->rules->removeElement($rule);
    }
}
