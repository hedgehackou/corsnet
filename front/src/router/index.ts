import Vue from "vue";
import VueRouter, { RouteConfig } from "vue-router";
import Install from "@/modules/install/Install.vue";
import AdminIndex from "@/modules/index/AdminIndex.vue";
import { NavigationGuardNext, Route } from "vue-router/types/router";
import store from "@/store/index";
import Login from "@/modules/auth/login/Login.vue";
import ForgotPassword from "@/modules/auth/forgot-password/ForgotPassword.vue";
import ResetPassword from "@/modules/auth/reset-password/ResetPassword.vue";
import i18n from "@/i18n";

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [
  ...(process.env.NODE_ENV !== "production"
    ? [{ path: "/", redirect: "/admin" }]
    : []),
  {
    path: "/admin",
    name: "admin-index",
    component: AdminIndex,
    meta: { requiresAuth: true },
    children: [],
  },
  {
    path: "/user",
    name: "user-index",
    component: {
      template: `<div>Users page</div>`,
    },
    meta: { requiresAuth: true },
    children: [],
  },
  {
    path: "/login",
    name: "login",
    component: Login,
    meta: { guest: true },
  },
  {
    path: "/forgot-password",
    name: "forgot-password",
    component: ForgotPassword,
    meta: { guest: true },
  },
  {
    path: "/reset-password/:token",
    name: "reset-password",
    component: ResetPassword,
  },
  {
    path: "/install",
    name: "install",
    component: Install,
  },
  {
    path: "*",
    redirect() {
      return "/";
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
  store.dispatch("AuthStore/fetchSettings").then((response) => {
    i18n.locale = response.lang;
  });
  await store.dispatch("AuthStore/fetchProfile");
  await store.dispatch("InstallStore/isProjectInstalled").then(({ status }) => {
    if (status || to.name === "install") {
      if (status && to.name === "install") {
        next({ name: "admin-index" });
      }
      next();
    } else {
      next({ name: "install" });
    }
  });
});

router.beforeEach(async (to: Route, from: Route, next: NavigationGuardNext) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (store.getters["AuthStore/isAuthorized"]) {
      next();
      return;
    }
    next({ name: "login" });
  } else {
    next();
  }
});

router.beforeEach((to: Route, from: Route, next: NavigationGuardNext) => {
  if (to.matched.some((record) => record.meta.guest)) {
    if (store.getters["AuthStore/isAuthorized"]) {
      next({ name: "admin-index" });
      return;
    }
    next();
  } else {
    next();
  }
});

export default router;
