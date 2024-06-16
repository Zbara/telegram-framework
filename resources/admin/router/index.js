import {
    createRouter,
    createWebHistory
} from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/admin/login",
            name: "login",
            component: () => import("../pages/Login.vue"),
        },

        {
            path: "/admin",
            name: "main",
            component: () => import("../pages/Main.vue"),
        },

        /** Users **/
        {
            path: "/admin/users",
            name: "users",
            component: () => import("../pages/Users/Main.vue"),
            props: route => ({
                direction: route.query.direction || 'created_at',
                sort: route.query.sort || 'desc',
                name: route.query.name,
                status: route.query.status,
                phone: route.query.phone,
                created_at: route.query.created_at,
                page: route.query.page || 1,
                editBox: route.query.editBox,
                editId: route.query.editId,
            })
        },
        /** Settings **/
        {
            path: "/admin/settings",
            name: "settings",
            component: () => import("../pages/Settings/Main.vue"),
        },
        {
            path: "/admin/language",
            name: "language",
            component: () => import("../pages/Language/Language.vue"),
        },
        {
            path: "/admin/language/text",
            name: "languageText",
            component: () => import("../pages/Language/LanguageText.vue"),
        },
        {
            path: "/admin/settings/admin",
            name: "settingsAdmin",
            component: () => import("../pages/Admin/Admin.vue"),
        },
        {
            path: "/admin/settings/admin/:id/edit",
            name: "settings.admin.edit",
            component: () => import("../pages/Admin/AdminEdit.vue"),
        },
        {
            path: "/admin/settings/server",
            name: "settingsServer",
            component: () => import("../pages/Settings/Server.vue"),
        },
        {
            path: '/:pathMatch(.*)*',
            component: () => import("../pages/Error/Error-404.vue"),
        },
    ],
});


router.beforeEach((to, from, next) => {
    const publicPages = ['/admin/login'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('token-admin');

    if (authRequired && !loggedIn) {
        next('/admin/login');
    } else {
        next();
    }
});

export default router;
