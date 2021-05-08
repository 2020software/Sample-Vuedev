import QuestionsPage from '../pages/QuestionsPage.vue'
import QuestionPage from '../pages/QuestionPage.vue'
import NotFoundPage from '../pages/NotFoundPage.vue'
import CreateQuestionPage from '../pages/CreateQuestionPage.vue'
import EditQuestionPage from '../pages/EditQuestionPage.vue'

//  500 (Internal Server Error) はapiに問題

const routes = [
    {
        path: '/',
        component: QuestionsPage,
        name: 'home'
    },
    {
        path: '/home',
        component: QuestionsPage,
        name: 'home'
    },
    {
        path: '/questions',
        component: QuestionsPage,
        name: 'questions'
    },
    {
        path: '/questions/create',
        component: CreateQuestionPage,
        name: 'questions.create',
        meta: {     
            requiresAuth: true  // ユーザーが正常にログインした場合にのみアクセス
        }
    },
    {
        path: '/questoins/:id/edit',    // :idはslugの数字部分
        component: EditQuestionPage,
        name: 'questions.edit'
    },
    {
        path: '/questions/:slug',   // URLパスパラメータ
        component: QuestionPage,
        name: 'questions.show',
        props: true,    // router-linkでpropsに値を渡してURL遷移する
        meta: {     
            requiresAuth: true  // ユーザーが正常にログインした場合にのみアクセス
        }
    },
    {
        path: '*',
        component: NotFoundPage
    }
]

export default routes