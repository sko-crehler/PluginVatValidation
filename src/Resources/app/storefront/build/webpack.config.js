const { join, resolve } = require('path');
module.exports = () => {
    return {
        resolve: {
            alias: {
                'jsvat': resolve(
                    join(__dirname, '../../../../../', 'node_modules', 'jsvat')
                )
            }
        }
    };
}
