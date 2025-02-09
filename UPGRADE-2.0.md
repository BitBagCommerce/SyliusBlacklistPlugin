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
   ```xml
   <service id="bitbag.sylius_blacklist_plugin.form.type.automatic_blacklisting_configuration"
            class="BitBag\SyliusBlacklistPlugin\Form\Type\AutomaticBlacklistingConfigurationType">
       <argument>%bitbag.sylius_blacklist_plugin.automatic_blacklisting_rules%</argument>
       <argument>%bitbag_sylius_blacklist_plugin.model.automatic_blacklisting_configuration.class%</argument>
       <argument>%bitbag.sylius_blacklist_plugin.form.type.validation_groups%</argument>
       <tag name="form.type" />
   </service>
   
   <service id="sylius.form.type.checkout_address" class="Sylius\Bundle\CoreBundle\Form\Type\Checkout\AddressType">
       <argument type="service" id="sylius.comparator.address" />
       <argument>%sylius.model.order.class%</argument>
       <argument>%bitbag.sylius_blacklist_plugin.form.type.checkout_address.validation_groups%</argument>
       <argument type="service" id="sylius.address_comparator" />
       <tag name="form.type" />
   </service>

   <service id="bitbag.sylius_blacklist_plugin.form.type.customer_autocomplete" class="BitBag\SyliusBlacklistPlugin\Form\Type\CustomerAutocompleteType">
       <argument>%sylius.model.customer.class%</argument>
       <tag name="form.type" />
       <tag name="ux.entity_autocomplete_field" />
   </service>

   <service id="bitbag.sylius_blacklist_plugin.state_resolver.customer" class="BitBag\SyliusBlacklistPlugin\StateResolver\CustomerStateResolver">
       <argument type="service" id="sm.factory" />
       <argument type="service" id="sylius.manager.customer" />
       <argument type="service" id="state_machine.bitbag_sylius_blacklist_plugin_customer" />
       <argument type="service" id="doctrine.orm.entity_manager" />
   </service>
   
   <service id="bitbag.sylius_blacklist_plugin.twig.extension.labels.automatic_blacklisting_configuration" class="BitBag\SyliusBlacklistPlugin\Twig\AutomaticBlacklistingConfigurationLabelsExtension">
        <argument>%bitbag.sylius_blacklist_plugin.automatic_blacklisting_rules%</argument>
        <tag name="twig.extension"/>
   </service>
   
   (...)
   ```

2. Additional service modifications (template downloaded from twig_hooks):

   ```xml
   <service id="bitbag.sylius_blacklist_plugin.twig.component.automatic_blacklisting_configuration.form" class="Sylius\Bundle\UiBundle\Twig\Component\ResourceFormComponent">
         <argument type="service" id="bitbag_sylius_blacklist_plugin.repository.automatic_blacklisting_configuration" />
         <argument type="service" id="form.factory" />
         <argument>%bitbag_sylius_blacklist_plugin.model.automatic_blacklisting_configuration.class%</argument>
         <argument>BitBag\SyliusBlacklistPlugin\Form\Type\AutomaticBlacklistingConfigurationType</argument>
         <tag name="sylius.live_component.admin" key="sylius_admin:automatic_blacklisting_configuration:form"/>
   </service>

   <service id="bitbag.sylius_blacklist_plugin.twig.component.blacklisting_rule.form" class="Sylius\Bundle\UiBundle\Twig\Component\ResourceFormComponent">
         <argument type="service" id="bitbag_sylius_blacklist_plugin.repository.blacklisting_rule" />
         <argument type="service" id="form.factory" />
         <argument>%bitbag_sylius_blacklist_plugin.model.blacklisting_rule.class%</argument>
         <argument>BitBag\SyliusBlacklistPlugin\Form\Type\BlacklistingRuleType</argument>
         <tag name="sylius.live_component.admin" key="sylius_admin:blacklisting_rule:form"/>
   </service>

   <service id="bitbag.sylius_blacklist_plugin.twig.component.fraud_suspicion.form" class="Sylius\Bundle\UiBundle\Twig\Component\ResourceFormComponent">
         <argument type="service" id="bitbag_sylius_blacklist_plugin.repository.fraud_suspicion" />
         <argument type="service" id="form.factory" />
         <argument>%bitbag_sylius_blacklist_plugin.model.fraud_suspicion.class%</argument>
         <argument>BitBag\SyliusBlacklistPlugin\Form\Type\FraudSuspicionType</argument>
         <tag name="sylius.live_component.admin" key="sylius_admin:fraud_suspicion:form"/>
   </service>
   ```

3. **Container Service Visibility Changes**: The visibility of services has been set to `private` by default, following Symfony best practices. Services used in controllers and event listeners remain public where necessary.


## Routing Updates

1. The route **bitbag_sylius_blacklist_plugin_admin_fraud_suspicion_show** has been replaced with **sylius_admin_fraud_suspicion_show**. Update your routes configuration accordingly:

```yaml
sylius_admin_fraud_suspicion_show:
    path: /admin/fraud-suspicion/{id}
    controller: BitBag\SyliusBlacklistPlugin\Controller\FraudSuspicionController::showAction
```

## Admin Panel Adjustments

1. **No need to overwrite templates**:
   Thanks to the use of Twig Hooks and the refactoring of templates, you no longer need to overwrite templates to use plugin features.

## Twig Hook Integrations

```yaml
sylius_twig_hooks:
    hooks:
        'sylius_admin.automatic_blacklisting_configuration.create.content':
            form:
                component: 'sylius_admin:automatic_blacklisting_configuration:form'
                props:
                    resource: '@=_context.resource'
                    form: '@=_context.form'
                    template: '@BitBagSyliusBlacklistPlugin/AutomaticBlacklistingConfiguration/Admin/form.html.twig'
                configuration:
                    render_rest: false
```

More Twig Hooks are available for different contexts, including:

- `sylius_admin.automatic_blacklisting_configuration.update.content`
- `sylius_admin.blacklisting_rule.create.content`
- `sylius_admin.blacklisting_rule.update.content`
- `sylius_admin.fraud_suspicion.create.content`
- `sylius_admin.fraud_suspicion.update.content`
- `sylius_admin.fraud_suspicion.show.content`

## Overwritten Sylius Templates

```yaml
sylius_twig_hooks:
   hooks:
      'sylius_admin.customer.update.content.form.sections#right':
         extra_information:
            template: '@BitBagSyliusBlacklistPlugin/Customer/Form/Sections/extra_information.html.twig'
            priority: 0

sylius_twig_hooks:
   hooks:
      'sylius_admin.customer.update.content.form.sections#right':
         extra_information:
            template: '@BitBagSyliusBlacklistPlugin/Customer/Form/Sections/extra_information.html.twig'
            priority: 0

sylius_twig_hooks:
   hooks:
      'sylius_admin.order.show.content.header.title_block':
         title:
            template: '@SyliusAdmin/order/show/content/header/title_block/title.html.twig'
            priority: 100
         actions:
            template: '@BitBagSyliusBlacklistPlugin/Order/Show/Content/Header/Title_block/actions.html.twig'
            priority: 0
```

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

1. Ensure your application is upgraded to Sylius 2.0:
   ```bash
   composer require sylius/sylius:~2.0.0 --no-update
   ```
2. To update the plugin, run the following command:
   ```bash
   composer require bitbag/blacklist-plugin:^2.0 --no-update
   ```
3. To ensure proper routing configuration, update the path in your Symfony project:

   Replace the following:
      ```
      bitbag_sylius_blacklist_plugin:
       resource: "@BitBagSyliusBlacklistPlugin/Resources/config/routing.yaml"
      ```   

   With:
      ```
      bitbag_sylius_blacklist_plugin:
       resource: "@BitBagSyliusBlacklistPlugin/config/routing.yaml"
      ```
3. Update your dependencies:
   ```bash
   composer update
   ```
4. Verify your routes and service configurations as described above.
5. Verify your templates and hooks for any required adjustments.

After completing these steps, your Sylius Blacklist Plugin should be fully functional with Sylius 2.0.

