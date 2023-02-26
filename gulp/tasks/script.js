import uglify from "gulp-uglify";

export const script = () => {
  return app.gulp
    .src(app.path.src.script, { sourcemaps: true })
    .pipe(uglify())
    .pipe(
      app.plugins.rename({
        extname: ".min.js",
      })
    )
    .pipe(app.gulp.dest(app.path.build.script))
    .pipe(app.plugins.browsersync.stream());
};
