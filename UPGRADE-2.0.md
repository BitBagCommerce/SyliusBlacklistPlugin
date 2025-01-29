# UPGRADE FROM 1.X TO 2.0

## General Changes

1. **Support for Sylius 2.0**: The plugin is now fully compatible with Sylius 2.0 and is the recommended version to use.
2. **Dropped Support for Sylius 1.X**: Applications must be upgraded to [Sylius 2.0](https://github.com/Sylius/Sylius/blob/2.0/UPGRADE-2.0.md) to continue using this plugin.
3. **PHP Compatibility**: The minimum supported PHP version has been increased to **8.2**.

## Structural Changes

### Directory Structure Updates

Following Symfony's latest recommendations, the directory structure has been updated:

- `@SyliusBlacklistPlugin/Resources/assets` → `@SyliusBlacklistPlugin/assets`
- `@SyliusBlacklistPlugin/Resources/config` → `@SyliusBlacklistPlugin/config`
- `@SyliusBlacklistPlugin/Resources/translations` → `@SyliusBlacklistPlugin/translations`
- `@SyliusBlacklistPlugin/Resources/views` → `@SyliusBlacklistPlugin/templates`

## Service Modifications

1. Several services have been modified to align with Sylius 2.0's structure. For example:

   The service **bitbag.sylius\_blacklist\_plugin.form.type.automatic\_blacklisting\_configuration** has been updated:

   ```xml
   <service id="bitbag.sylius_blacklist_plugin.form.type.automatic_blacklisting_configuration"
            class="BitBag\SyliusBlacklistPlugin\Form\Type\AutomaticBlacklistingConfigurationType">
       <argument>%bitbag.sylius_blacklist_plugin.automatic_blacklisting_rules%</argument>
       <argument>%bitbag_sylius_blacklist_plugin.model.automatic_blacklisting_configuration.class%</argument>
       <argument>%bitbag.sylius_blacklist_plugin.form.type.validation_groups%</argument>
       <tag name="form.type" />
   </service>
   ```

2. **Container Service Visibility Changes**: The visibility of services has been set to `private` by default, following Symfony best practices. Services used in controllers and event listeners remain public where necessary.

## Routing Updates

1. The route **bitbag\_sylius\_blacklist\_plugin\_admin\_fraud\_suspicion\_show** has been replaced with **sylius\_admin\_fraud\_suspicion\_show**. Update your routes configuration accordingly:
   ```yaml
   sylius_admin_fraud_suspicion_show:
       path: /admin/fraud-suspicion/{id}
       controller: BitBag\SyliusBlacklistPlugin\Controller\FraudSuspicionController::showAction
   ```

## Admin Panel Adjustments

1. **No need to overwrite templates**:
   Thanks to the use of Twig Hooks and the refactoring of templates, you no longer need to overwrite templates to use plugin features.

## Configuration Updates

1. **Winzou State Machine Removed**:
   - The Winzou State Machine has been completely removed.
   - Instead, the **Symfony Workflow** component has been introduced for managing state transitions.
   - Update your configuration to use `workflow` instead of `state_machine`.

   Example:
   ```yaml
   framework:
     workflows:
       !php/const BitBag\SyliusBlacklistPlugin\Transitions\CustomerTransitions::GRAPH:
         type: state_machine
         marking_store:
           property: fraudStatus
           type: method
         supports:
           - BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface
         initial_marking:
           !php/const BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface::FRAUD_STATUS_NEUTRAL
         places:
           - !php/const BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface::FRAUD_STATUS_NEUTRAL
           - !php/const BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface::FRAUD_STATUS_BLACKLISTED
           - !php/const BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface::FRAUD_STATUS_WHITELISTED
         transitions:
           !php/const BitBag\SyliusBlacklistPlugin\Transitions\CustomerTransitions::TRANSITION_NEUTRALIZING_PROCESS:
             from:
               - !php/const BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface::FRAUD_STATUS_BLACKLISTED
             to:
               - !php/const BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface::FRAUD_STATUS_NEUTRAL
           !php/const BitBag\SyliusBlacklistPlugin\Transitions\CustomerTransitions::TRANSITION_BLACKLISTING_PROCESS:
             from:
               - !php/const BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface::FRAUD_STATUS_NEUTRAL
             to:
               - !php/const BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface::FRAUD_STATUS_BLACKLISTED
           !php/const BitBag\SyliusBlacklistPlugin\Transitions\CustomerTransitions::TRANSITION_WHITELISTING_PROCESS:
             from:
               - !php/const BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface::FRAUD_STATUS_NEUTRAL
             to:
               - !php/const BitBag\SyliusBlacklistPlugin\Entity\Customer\FraudStatusInterface::FRAUD_STATUS_WHITELISTED
   ```

## Removed Features

1. **Legacy Support Removed**:
   - Removed compatibility layers for Sylius 1.X.
   - Dropped support for deprecated interfaces and methods in Sylius 2.0.

## How to Upgrade

1. Ensure your application is upgraded to Sylius 2.0.
   ```bash
   composer require sylius/sylius:~2.0.0 --no-update
   ```
2. To update the plugin, run the following command:
   ```bash
   composer require bitbag/blacklist-plugin:^2.0 --no-update
   ```
3. Update your dependencies:
   ```bash
   composer update
   ```   
3. Verify your routes and service configurations as described above.
4. Verify your templates and hooks for any required adjustments.

After completing these steps, your Sylius Blacklist Plugin should be fully functional with Sylius 2.0.

