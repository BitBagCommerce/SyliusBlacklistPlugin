<h1 align="center">
    <a href="http://bitbag.shop" target="_blank">
        <img src="doc/logo.png" width="55%" />
    </a>
    <br/>
    <a href="https://packagist.org/packages/bitbag/wishlist-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/bitbag/wishlist-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/bitbag/wishlist-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/bitbag/wishlist-plugin.svg" />
    </a>
    <a href="http://travis-ci.org/BitBagCommerce/SyliusWishlistPlugin" title="Build status" target="_blank">
            <img src="https://img.shields.io/travis/BitBagCommerce/SyliusWishlistPlugin/master.svg" />
        </a>
    <a href="https://scrutinizer-ci.com/g/BitBagCommerce/SyliusWishlistPlugin/" title="Scrutinizer" target="_blank">
        <img src="https://img.shields.io/scrutinizer/g/BitBagCommerce/SyliusWishlistPlugin.svg" />
    </a>
    <a href="https://packagist.org/packages/bitbag/wishlist-plugin" title="Total Downloads" target="_blank">
        <img src="https://poser.pugx.org/bitbag/wishlist-plugin/downloads" />
    </a>
    <p>
        <a href="https://sylius.com/plugins/" target="_blank">
            <img src="https://sylius.com/assets/badge-approved-by-sylius.png" width="85">
        </a>
    </p>
</h1>

## About us

At BitBag we do believe in open source. However, we are able to do it just beacuse of our awesome clients, who are kind enough to share some parts of our work with the community. Therefore, if you feel like there is a possibility for us working together, feel free to reach us out. You will find out more about our professional services, technologies and contact details at https://bitbag.io/.

## BitBag SyliusBlacklistPlugin

This plugin allows you to integrate blacklist features with Sylius platform app.

## Demo

We created a demo app with some useful use-cases of the plugin! Visit [demo.bitbag.shop](https://demo.bitbag.shop) to take a look at it. 
The admin can be accessed under [demo.bitbag.shop/admin](https://demo.bitbag.shop/admin) link and `sylius: sylius` credentials.

## Installation
```bash
$ composer require bitbag/blacklist-plugin
```
    
Add plugin dependencies to your `config/bundles.php` file:
```php
return [
    ...

    BitBag\SyliusBlacklistPlugin\BitBagSyliusBlacklistPlugin::class => ['all' => true],
];
```

Import required config in your `config/packages/_sylius.yaml` file:
```yaml
# config/packages/_sylius.yaml

imports:
    ...
    
    - { resource: "@BitBagSyliusBlacklistPlugin/Resources/config/config.yml" }
```

Import routing in your `config/routes.yaml` file:

```
# config/routes.yaml

bitbag_sylius_blacklist_plugin:
    resource: "@BitBagSyliusBlacklistPlugin/Resources/config/routing.yml"
```

Update your database

```
$ bin/console doctrine:migrations:migrate
```

**Note:** If you are running it on production, add the `-e prod` flag to this command.

## Usage

## Customization

### Available services you can [decorate](https://symfony.com/doc/current/service_container/service_decoration.html) and forms you can [extend](http://symfony.com/doc/current/form/create_form_type_extension.html)

Run the below command to see what Symfony services are shared with this plugin:
```bash
$ bin/console debug:container | grep bitbag_sylius_blacklist_plugin
```

### Parameters you can override in your parameters.yml(.dist) file
```yml
$ bin/console debug:container --parameters | grep bitbag
```

## Testing
```bash
$ composer install
$ cd tests/Application
$ yarn install
$ yarn build
$ bin/console assets:install public -e test
$ bin/console doctrine:schema:create -e test
$ bin/console server:run 127.0.0.1:8080 -d public -e test
$ open http://localhost:8080
$ cd ../..
$ vendor/bin/behat
$ vendor/bin/phpspec run
```

## Contribution

Learn more about our contribution workflow on http://docs.sylius.org/en/latest/contributing/.
