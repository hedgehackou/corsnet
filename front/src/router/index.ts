import Vue from "vue";
import store from "@/store/index";
import i18n from "@/i18n";
import { NavigationGuardNext, Route } from "vue-router/types/router";
import VueRouter, { RouteConfig } from "vue-router";
import Install from "@/modules/install/Install.vue";
import Index from "@/modules/index/Index.vue";
import Login from "@/modules/auth/login/Login.vue";
import ForgotPassword from "@/modules/auth/forgot-password/ForgotPassword.vue";
import ResetPassword from "@/modules/auth/reset-password/ResetPassword.vue";
import UserDashboard from "@/modules/user/dashboard/UserDashboard.vue";
import AdminInvitations from "@/modules/admin/invitations/AdminInvitations.vue";
import AdminUsers from "@/modules/admin/users/AdminUsers.vue";
import AcceptInvite from "@/modules/auth/invite/AcceptInvite.vue";
import BaseStations from "@/modules/admin/base-stations/BaseStations.vue";
import CreateEditBaseStation from "@/modules/admin/base-stations/components/CreateEditBaseStation.vue";
import Receivers from "@/modules/admin/base-stations/components/Receivers.vue";
import ViewBaseStation from "@/modules/admin/base-stations/components/ViewBaseStation.vue";
import UsersView from "@/modules/admin/users/components/UsersView.vue";
import Casters from "@/modules/admin/casters/Casters.vue";
import CreateEditCaster from "@/modules/admin/casters/components/CreateEditCaster.vue";
import ViewCaster from "@/modules/admin/casters/components/ViewCaster.vue";

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [
  ...(process.env.NODE_ENV !== "production"
    ? [{ path: "/", redirect: "/admin" }]
    : []),
  {
    path: "/admin",
    component: Index,
    meta: { requiresAuth: true, forAdmin: true },
    children: [
      {
        path: "",
        name: "admin-dashboard",
      },
      {
        path: "invitations",
        name: "admin-invitations",
        component: AdminInvitations,
        meta: { requiresAuth: true, forAdmin: true },
      },
      {
        path: "users",
        component: {
          template: "<router-view />",
        },
        meta: { requiresAuth: true, forAdmin: true },
        children: [
          {
            path: "",
            name: "admin-users",
            component: AdminUsers,
            meta: { requiresAuth: true, forAdmin: true },
          },
          {
            path: "view/:userId",
            name: "admin-user-view",
            component: UsersView,
            meta: { requiresAuth: true, forAdmin: true },
            props: (route) => ({
              userId: +route.params.userId,
            }),
          },
        ],
      },
      {
        path: "base-stations",
        component: {
          template: "<router-view />",
        },
        children: [
          {
            path: "",
            name: "admin-base-stations",
            component: BaseStations,
            meta: { requiresAuth: true, forAdmin: true },
          },
          {
            path: "create",
            name: "admin-create-base-station",
            component: CreateEditBaseStation,
            meta: { requiresAuth: true, forAdmin: true },
          },
          {
            path: "edit/:baseStationId",
            name: "admin-edit-base-station",
            component: CreateEditBaseStation,
            meta: { requiresAuth: true, forAdmin: true },
            props: (route) => ({
              baseStationId: +route.params.baseStationId,
              editMode: true,
            }),
          },
          {
            path: "view/:baseStationId",
            name: "admin-view-base-station",
            component: ViewBaseStation,
            meta: { requiresAuth: true, forAdmin: true },
            props: (route) => ({
              baseStationId: +route.params.baseStationId,
            }),
          },
          {
            path: "edit/:baseStationId/receivers",
            name: "admin-base-station-receivers",
            component: Receivers,
            meta: { requiresAuth: true, forAdmin: true },
          },
        ],
      },
      {
        path: "casters",
        component: {
          template: "<router-view />",
        },
        children: [
          {
            path: "",
            name: "admin-casters",
            component: Casters,
            meta: { requiresAuth: true, forAdmin: true },
          },
          {
            path: "create",
            name: "admin-create-caster",
            component: CreateEditCaster,
            meta: { requiresAuth: true, forAdmin: true },
          },
          {
            path: "edit/:casterId",
            name: "admin-edit-caster",
            component: CreateEditCaster,
            meta: { requiresAuth: true, forAdmin: true },
            props: (route) => ({
              casterId: +route.params.casterId,
              editMode: true,
            }),
          },
          {
            path: "view/:casterId",
            name: "admin-view-caster",
            component: ViewCaster,
            meta: { requiresAuth: true, forAdmin: true },
            props: (route) => ({
              casterId: +route.params.casterId,
            }),
          },
        ],
      },
    ],
  },
  {
    path: "/user",
    name: "",
    component: Index,
    meta: { requiresAuth: true, forUser: true },
    children: [
      {
        path: "",
        name: "user-dashboard",
        component: UserDashboard,
        meta: { requiresAuth: true },
      },
      {
        path: "base-stations",
        component: {
          template: "<router-view />",
        },
        children: [
          {
            path: "",
            name: "user-base-stations",
            component: BaseStations,
            meta: { requiresAuth: true, forAdmin: false },
          },
          {
            path: "view/:baseStationId",
            name: "user-view-base-station",
            component: ViewBaseStation,
            meta: { requiresAuth: true, forAdmin: false },
            props: (route) => ({
              baseStationId: +route.params.baseStationId,
            }),
          },
        ],
      },
    ],
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
    path: "/accept-invite/:token",
    name: "accept-invite",
    component: AcceptInvite,
  },
  {
    path: "/install",
    name: "install",
    component: Install,
  },
  {
    path: "*",
    redirect() {
      return "/admin";
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
        window.location.href = "/";
      } else {
        next();
      }
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

router.beforeEach(async (to: Route, from: Route, next: NavigationGuardNext) => {
  if (to.matched.some((record) => record.meta.forAdmin)) {
    if (store.getters["AuthStore/isAuthorized"]) {
      if (store.getters["AuthStore/isAdmin"]) {
        next();
      } else {
        next({ name: "user-dashboard" });
      }
    }
  }
  if (to.matched.some((record) => record.meta.forUser)) {
    if (store.getters["AuthStore/isAuthorized"]) {
      if (!store.getters["AuthStore/isAdmin"]) {
        next();
      } else {
        next({ name: "admin-dashboard" });
      }
    }
  }
  next();
});

router.beforeEach((to: Route, from: Route, next: NavigationGuardNext) => {
  if (to.matched.some((record) => record.meta.guest)) {
    if (store.getters["AuthStore/isAuthorized"]) {
      if (store.getters["AuthStore/isAdmin"]) {
        next({ name: "admin-dashboard" });
      } else {
        next({ name: "user-dashboard" });
      }
    }
    next();
  } else {
    next();
  }
});

export default router;
