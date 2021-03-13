const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            '@@': path.resolve('_packages'),
            '@packages': path.resolve('_packages/katzsimon'),
            '@packagesBase': path.resolve('_packages/katzsimon/base/resources/js'),
        },
    }
}
