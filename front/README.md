# frontend

##Install
1. ``cp .env.example .env.local``
2. ```
    VUE_APP_I18N_LOCALE=en - current local
    VUE_APP_I18N_FALLBACK_LOCALE=en - fallback local
    VUE_APP_API_URL=http://localhost:8080 - server address without "/api"
    VUE_APP_BASE_API_URL="/api" - api base path
    VUE_APP_PROXY_API_URL="http://corsnet" - proxy pass for dev (should be the same as VUE_APP_API_URL)
   ```

## Project setup
```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Lints and fixes files
```
npm run lint
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).
