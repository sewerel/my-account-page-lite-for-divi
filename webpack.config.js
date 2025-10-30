const webpack = require('webpack');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const config = {
    mode: 'development',
    //watch after first build
    watch: true,
    watchOptions: {
        ignored: /node_modules/,
    },
    entry: {
        builder: './divi-my-account-modules/includes/loader.js',
        //frontend:'./scripts/frontend.js'
    },
    output: {
        path: path.resolve(__dirname, 'divi-my-account-modules/scripts'),
        filename: '[name]-bundle.min.js'
    },
    externals: {
        react: 'React',
        jquery: 'jQuery'
    },
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                use: 'babel-loader',
                exclude: /node_modules/
            },
            {
                test: /\.css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader'
                ]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "../styles/style.min.css"
        })
    ]
};

module.exports = config;