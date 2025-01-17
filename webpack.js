const path = require('path')
const webpackConfig = require('@nextcloud/webpack-vue-config')

webpackConfig.entry['files'] = path.join(__dirname, 'src', 'files.js')
webpackConfig.entry['reference'] = path.join(__dirname, 'src', 'reference.js')

module.exports = webpackConfig
