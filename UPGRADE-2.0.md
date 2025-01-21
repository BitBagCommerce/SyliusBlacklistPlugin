# UPGRADE FROM 1.X TO 2.0

1. Support for Sylius 2.0 has been added, it is now the recommended Sylius version to use with Sylius Blacklist Plugin.

1. Support for Sylius 1.X has been dropped, upgrade your application to [Sylius 2.0](https://github.com/Sylius/Sylius/blob/2.0/UPGRADE-2.0.md).

1. The minimum supported version of PHP has been increased to 8.2.

1. Doctrine migrations have been regenerated, meaning all previous migration files have been removed and their content
   is now in a single migration file. To apply the new migration and get rid of the old entries run migrations as usual:

   ```bash
       bin/console doctrine:migrations:migrate --no-interaction
   ```

1. The structures of the directories have been updated to follow the current Symfony recommendations:
  - `@SyliusBlacklistPlugin/Resources/assets` -> `@SyliusBlacklistPlugin/assets`
  - `@SyliusBlacklistPlugin/Resources/config` -> `@SyliusBlacklistPlugin/config`
  - `@SyliusBlacklistPlugin/Resources/translations` -> `@SyliusBlacklistPlugin/translations`
  - `@SyliusBlacklistPlugin/Resources/views` -> `@SyliusBlacklistPlugin/templates`
