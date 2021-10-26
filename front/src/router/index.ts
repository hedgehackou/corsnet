import Vue from "vue";
import VueRouter, { RouteConfig } from "vue-router";
import Install from "@/modules/install/Install.vue";
import Index from "@/modules/index/Index.vue";
import { NavigationGuardNext, Route } from "vue-router/types/router";
import store from "@/store/index";
import i18n from "@/i18n";
import Login from "@/modules/auth/login/Login.vue";
import axios from "axios";
import ForgotPassword from "@/modules/auth/forgot-password/ForgotPassword.vue";

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [
  {
    path: "/:locale",
    component: {
      template: `<router-view></router-view>`,
    },
    beforeEnter: (to, from, next) => {
      const locale = to.params.locale;
      const supportedLocales = ["ru", "en"];
      //@ts-ignore
      axios.defaults.headers["Accept-Language"] = locale;
      if (!supportedLocales.includes(locale)) {
        return next("en");
      }
      if (i18n.locale !== locale) {
        i18n.locale = locale;
      }
      return next();
    },
    children: [
      {
        path: "",
        name: "index",
        component: Index,
        meta: { requiresAuth: true },
      },
      {
        path: "login",
        name: "login",
        component: Login,
        meta: { guest: true },
      },
      {
        path: "forgot-password",
        name: "forgot-password",
        component: ForgotPassword,
        meta: { guest: true },
      },
      {
        path: "install",
        name: "install",
        component: Install,
      },
    ],
  },
  {
    path: "*",
    redirect() {
      return process.env.VUE_APP_I18N_LOCALE;
    },
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
}) as any;

router.duplicationErroringPush = router.push;
router.push = async function (location: any) {
  return router.duplicationErroringPush(location).catch((error: any) => {
    if (error.name === "NavigationDuplicated") {
      return this.currentRoute;
    }
    throw error;
  });
};

router.beforeEach(async (to: Route, from: Route, next: NavigationGuardNext) => {
  await store.dispatch("AuthStore/fetchProfile");
  await store.dispatch("InstallStore/isProjectInstalled").then(({ status }) => {
    if (status || to.name === "install") {
      if (status && to.name === "install") {
        next({ name: "index", params: { locale: i18n.locale } });
      }
      next();
    } else {
      next({ name: "install", params: { locale: i18n.locale } });
    }
  });
});

router.beforeEach(async (to: Route, from: Route, next: NavigationGuardNext) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (store.getters["AuthStore/isAuthorized"]) {
      next();
      return;
    }
    next({ name: "login", params: { locale: i18n.locale } });
  } else {
    next();
  }
});

router.beforeEach((to: Route, from: Route, next: NavigationGuardNext) => {
  if (to.matched.some((record) => record.meta.guest)) {
    if (store.getters["AuthStore/isAuthorized"]) {
      next({ name: "index", params: { locale: i18n.locale } });
      return;
    }
    next();
  } else {
    next();
  }
});

export default router;
