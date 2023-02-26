import gulp from "gulp";

import { path } from "./gulp/config/path.js";
import { plugins } from "./gulp/config/plugins.js";

global.app = {
  path: path,
  gulp: gulp,
  plugins: plugins,
};

import { reset } from "./gulp/tasks/reset.js";
import { html } from "./gulp/tasks/html.js";
import { server } from "./gulp/tasks/server.js";
import { style } from "./gulp/tasks/style.js";
import { script } from "./gulp/tasks/script.js";
import { image } from "./gulp/tasks/image.js";
import { font } from "./gulp/tasks/font.js";
import { ghPages } from "./gulp/tasks/ghpages.js";

function watcher() {
  gulp.watch(path.watch.html, html);
  gulp.watch(path.watch.style, style);
  gulp.watch(path.watch.script, script);
  gulp.watch(path.watch.image, image);
}

const mainTasks = gulp.parallel(html, style, script, image);

const dev = gulp.series(reset, font, mainTasks, gulp.parallel(watcher, server));

gulp.task("deploy", ghPages);

gulp.task("default", dev);
