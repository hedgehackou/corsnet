import Vue from "vue";
import VueRouter, { RouteConfig } from "vue-router";
import Install from "@/modules/install/Install.vue";
import Index from "@/modules/index/Index.vue";
import { NavigationGuardNext, Route } from "vue-router/types/router";
import store from "@/store/index";
import i18n from "@/i18n";

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
  next();
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

export default router;
