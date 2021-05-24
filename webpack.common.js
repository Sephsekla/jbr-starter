const path = require('path');

//const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
//const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");

const autoprefixer = require('autoprefixer');

const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const FixStyleOnlyEntriesPlugin = require("webpack-fix-style-only-entries");

const CriticalCSSPlugin = require('critical-css-webpack-plugin');


const sassLoaders = [{
    loader: 'css-loader',
    options: {
      url: false,
      sourceMap: true

    }
  },

  {
    loader: 'postcss-loader',
    options: {
      postcssOptions: {
        plugins: [autoprefixer],
      },
      sourceMap: true
    }
  },

  {
    loader: "sass-loader",
    options: {
      sourceMap: true,
      implementation: require("node-sass")
    }

  }
];


module.exports = {

  devServer: {
    stats: {
      colors: true,
      hash: false,
      version: false,
      timings: false,
      assets: false,
      chunks: false,
      modules: false,
      reasons: false,
      children: false,
      source: false,
      errors: true,
      errorDetails: true,
      warnings: true,
      publicPath: false
    }
  },


  resolve: {
    alias: {
      assets: path.resolve(__dirname, 'dist/assets'),
      submodules: path.resolve(__dirname, 'submodules'),
    },
  },

  entry: {

    'main': './src/index.js',
    'blocks': './src/blocks.js',
    'main.min': './src/sass/style.scss',
    'editor.min': './src/sass/editor/scss'

  },
  plugins: [
    new FixStyleOnlyEntriesPlugin(),
    new MiniCssExtractPlugin({
      filename: ({
        chunk
      }) => `${chunk.name}.css`,
    }),
    new CriticalCSSPlugin({
      src: 'https://jbr.digital/?generate-critical=true',
      target: 'dist/critical.css',
      width: 480,
      height: 800,
      minify: true,
    }),
  ],
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'dist')
  },



  //When run in WordPress we want to use external jquery
  externals: {
    jquery: 'jQuery',
    lodash: 'lodash',
    wp: 'wp'
  },
  module: {
    rules: [

      /* JS Files */
      {
        test: /\.js$/,
        exclude: /(node_modules|bower_components)/,
        use: [{
          loader: 'babel-loader',
          options: {
            presets: ['@wordpress/babel-preset-default'],
            plugins: ["lodash"],
            sourceType: "unambiguous",
          }
        }, {
          loader: "ifdef-loader",
          options: {
            DEBUG: false,
          }
        }]
      },


      /*Images*/
      {
        test: /\.(png|jpg|gif)$/,
        use: [{
          loader: 'file-loader',
          options: {}
        }]
      },

      /*SCSS*/
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
        ].concat(sassLoaders)
      },

      /*CSS*/
      {
        test: /\.css$/,
        use: [
          'style-loader',
          {
            loader: 'css-loader',
            options: {
              url: false,
              sourceMap: true

            }
          }
        ]
      }

    ]
  }

};