const { merge } = require('webpack-merge');
const common = require('./webpack.common.js');
const WebpackShellPlugin = require('webpack-shell-plugin');


module.exports = merge(common, {
 mode: 'development',
 devtool: 'inline-source-map',
 devServer: {
   contentBase: './dist',
   sourceMap: true
  },
 
  plugins: [
 
],
 
  module: {
 
    rules: [
      {
        test: /\.js$/,
        exclude: /(node_modules|bower_components)/,
        use: [{
          loader: 'babel-loader',
          options: {
            presets: ["@wordpress/default"],
            sourceMap: true

          }
        },
        {
          loader: "ifdef-loader", options: {
            DEBUG: true,
          }
        }
        ]
      },
    ]
  }
});
    