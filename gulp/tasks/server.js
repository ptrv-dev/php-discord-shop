export const server = () => {
  app.plugins.browsersync.init({
    proxy: "localhost",
  });
};
