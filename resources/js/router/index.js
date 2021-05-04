import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './routes'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: 'active'
})

// ルートメタフィールド
router.beforeEach((to, from, next) => {
    // routes.jsにあるコンポーネントがrequiresAuth = trueかつログインしていないとき
    if (to.matched.some(record => record.meta.requiresAuth) && !window.Auth.signedIn) {
        // このルートはログインされているかどうか認証が必要
        // もしされていないならば、ログインページにリダイレクト
        window.location = window.Urls.login  // spa.blade.phpの 'url' => route('login')
        return
    }
    next() // next() を常に呼び出す
})

export default router