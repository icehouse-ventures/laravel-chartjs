/** @type {import('vite').UserConfig} */
export default {
    build: {
        assetsDir: "",
        emptyOutDir: false,
        rollupOptions: {
            input: ["src/resources/js/chart.js"],
            output: {
                assetFileNames: "[name][extname]",
                entryFileNames: "[name].js",
            },
        },
    },
};
