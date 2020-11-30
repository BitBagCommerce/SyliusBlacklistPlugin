<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\AutomaticBlacklistingConfiguration;

use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;
use Tests\BitBag\SyliusBlacklistPlugin\Behat\Behaviour\ContainsEmptyListTrait;

class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    use ContainsEmptyListTrait;

    public function getBlocksWithTypeCount(string $type): int
    {
        $tableAccessor = $this->getTableAccessor();
        $table = $this->getElement('table');

        return count($tableAccessor->getRowsWithFields($table, ['type' => $type]));
    }

    public function deleteBlacklistingRule(string $name): void
    {
        $this->deleteResourceOnPage(['name' => $name]);
    }

    public function isBlacklistingRuleDisabled(string $name): bool
    {
        $tableAccessor = $this->getTableAccessor();
        $table = $this->getElement('table');

        $updatedRow = $tableAccessor->getRowWithFields($table, ['name' => $name]);
        $enabledText = $tableAccessor->getFieldFromRow($table, $updatedRow, 'enabled');

        if ($enabledText === 'Enabled') {
            return false;
        }

        return true;
    }
}
