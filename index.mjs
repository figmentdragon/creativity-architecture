var sass = import("sass");
var Fiber = import("fibers");
var fa = import("fontawesome");
var result = sass.renderSync({file:
    entry: path.resolve(__dirname, "theme/architecture.scss");

sass.render({
  file: "input.scss",
  importer: function(url, prev, done) {
    // ...
  },
  fiber: Fiber
}, function(err, result) {
  // ...
});
