const path = require('path');
const Encore = require('@symfony/webpack-encore');
const pluginName = 'blacklist';

const getConfig = (pluginName, type) => {
    Encore.reset();

    Encore
        .setOutputPath(`public/build/bitbag/${pluginName}/${type}/`)
        .setPublicPath(`/build/bitbag/${pluginName}/${type}/`)
        .addEntry(`bitbag-${pluginName}-${type}`, path.resolve(__dirname, `./assets/${type}/entry.js`))
        .disableSingleRuntimeChunk()
        .cleanupOutputBeforeBuild()
        .enableSourceMaps(!Encore.isProduction())
        .enableSassLoader();

    const config = Encore.getWebpackConfig();
    config.name = `bitbag-${pluginName}-${type}`;

    return config;
}

Encore
    .setOutputPath(`src/Resources/public/`)
    .setPublicPath(`/public/`)
    .addEntry(`bitbag-${pluginName}-shop`, path.resolve(__dirname, `./assets/shop/entry.js`))
    .addEntry(`bitbag-${pluginName}-admin`, path.resolve(__dirname, `./assets/admin/entry.js`))
    .cleanupOutputBeforeBuild()
    .disableSingleRuntimeChunk()
    .enableSassLoader();

const distConfig = Encore.getWebpackConfig();
distConfig.name = `bitbag-plugin-dist`;

Encore.reset();

const shopConfig = getConfig(pluginName, 'shop')
const adminConfig = getConfig(pluginName, 'admin')

module.exports = [shopConfig, adminConfig, distConfig];
