module.exports = {
  assetsDir: "spa",
  runtimeCompiler: true,
  pluginOptions: {
    i18n: {
      locale: "en",
      fallbackLocale: "en",
      localeDir: "locales",
      enableInSFC: true,
      enableBridge: false,
    },
  },
  configureWebpack: {
    devServer: {
      overlay: false,
      proxy: {
        "^/api": {
          target: process.env.VUE_APP_PROXY_API_URL,
          ws: true,
          secure: false,
          changeOrigin: true,
        },
      },
    },
  },
};
