import imagemin from "gulp-imagemin";
import webp from "gulp-webp";

export const image = () => {
  return app.gulp
    .src(app.path.src.image)
    .pipe(app.plugins.newer(app.path.build.image))
    .pipe(webp())
    .pipe(app.gulp.dest(app.path.build.image))

    .pipe(app.gulp.src(app.path.src.image))
    .pipe(app.plugins.newer(app.path.build.image))
    .pipe(
      imagemin({
        progressive: true,
        svgoPlugins: [{ removeViewBox: false }],
        interlaced: true,
        optimizationLevel: 3, //0 to 7
      })
    )
    .pipe(app.gulp.dest(app.path.build.image))
    .pipe(app.plugins.browsersync.stream());
};
