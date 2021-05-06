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
        meta: {     // ユーザーが正常にログインした場合にのみアクセス
            requiresAuth: true
        }
    },
    {
        path: '/questoins/:id/edit',
        component: EditQuestionPage,
        name: 'questions.edit'
    },
    {
        path: '/questions/:slug',   // {slug}
        component: QuestionPage,
        name: 'questions.show',
        props: true,
        meta: {     // ユーザーが正常にログインした場合にのみアクセス
            requiresAuth: true
        }
    },
    {
        path: '*',
        component: NotFoundPage
    }
]

export default routes