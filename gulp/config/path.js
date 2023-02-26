const buildFolder = `./dist`;
const srcFolder = `./src`;

export const path = {
  build: {
    html: `${buildFolder}/`,
    style: `${buildFolder}/css/`,
    script: `${buildFolder}/js/`,
    image: `${buildFolder}/img/`,
    fonts: `${buildFolder}/fonts/`,
  },
  src: {
    html: `${srcFolder}/**/*.{html,php}`,
    style: `${srcFolder}/scss/**/*.scss`,
    script: `${srcFolder}/js/*.js`,
    image: `${srcFolder}/img/**/*.{jpg,jpeg,png,gif,svg,webp,ico}`,
    fonts: `${srcFolder}/fonts/`,
  },
  watch: {
    html: `${srcFolder}/**/*.{html,php}`,
    style: `${srcFolder}/scss/**/*.scss`,
    script: `${srcFolder}/js/*.js`,
    image: `${srcFolder}/img/**/*.{jpg,jpeg,png,gif,svg,webp,ico}`,
  },
  clean: buildFolder,
  buildFolder: buildFolder,
  srcFolder: srcFolder,
};
