const { merge } = require('webpack-merge');
const common = require('./webpack.common.js');
const TerserPlugin = require("terser-webpack-plugin");
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');



 module.exports = merge(common, {
   mode: 'production',
 /*  plugins: [
    new WebpackShellPlugin({

    })
  ], */
     optimization: {
      minimize: true,
        minimizer: [
         /* new UglifyJsPlugin({
            cache: true,
            parallel: true,
            sourceMap: false // set to true if you want JS source maps
          }), */
          new CssMinimizerPlugin(),
          new TerserPlugin({
            test: /\.js(\?.*)?$/i,
            extractComments: true,
          })
        ]
      },
 });