import dartSass from "sass";
import gulpSass from "gulp-sass";
import cleanCss from "gulp-clean-css";
import autoprefixer from "gulp-autoprefixer";

const sass = gulpSass(dartSass);

export const style = () => {
  return app.gulp
    .src(app.path.src.style, { sourcemaps: true })
    .pipe(sass())
    .pipe(autoprefixer())
    .pipe(app.gulp.dest(app.path.build.style))
    .pipe(cleanCss())
    .pipe(
      app.plugins.rename({
        extname: ".min.css",
      })
    )
    .pipe(app.gulp.dest(app.path.build.style))
    .pipe(app.plugins.browsersync.stream());
};
