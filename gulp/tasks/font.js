import fonter from "gulp-fonter";
import ttf2woff2 from "gulp-ttf2woff2";

export const font = () => {
  return app.gulp
    .src(app.path.src.fonts + "/**/*.ttf")
    .pipe(app.gulp.dest(app.path.build.fonts))
    .pipe(app.gulp.src(app.path.src.fonts + "/**/*.ttf"))
    .pipe(
      fonter({
        formats: ["woff"],
      })
    )
    .pipe(app.gulp.dest(app.path.build.fonts))
    .pipe(app.gulp.src(app.path.src.fonts + "/**/*.ttf"))
    .pipe(ttf2woff2())
    .pipe(app.gulp.dest(app.path.build.fonts));
};
