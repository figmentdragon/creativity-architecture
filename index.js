var sass = require("sass");
var Fiber = require("fibers");
var fa = require("fontawesome");

sass.render({
  file: "input.scss",
  importer: function(url, prev, done) {
    // ...
  },
  fiber: Fiber
}, function(err, result) {
  // ...
});

import 'node_modules/sass/sass.js'
import 'node_modules/sass/sass.dart.js'
import 'node_modules/sass/sass.default.dart.js'

import 'node_modules/fontawesome/index.js'
import 'node_modeuls/fontawesome/generate.js'
import Makefile from 'fontawesome/makefile'
export generate.js from 'fontawesome'
