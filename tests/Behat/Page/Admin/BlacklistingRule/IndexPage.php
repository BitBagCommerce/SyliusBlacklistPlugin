<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);
namespace Tests\BitBag\SyliusBlacklistPlugin\Behat\Page\Admin\BlacklistingRule;

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

        return $enabledText !== 'Enabled';
    }
}
