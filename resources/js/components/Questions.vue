<template>
    <div>
        <div class="card-body">
            <div v-if="questions.length">
                <question-item @deleted="remove(index)" v-for="(question, index) in questions" :key="question.id" :question="question"></question-item>
            </div>
            <div v-else class="alert alert-warning">
                質問はまだありません
            </div>
        </div>
        <div class="card-footer">
            <pagination :meta="meta" :links="links"></pagination>
        </div>
    </div>
</template>

<script>
import QuestionItem from './QuestionItem.vue'
import Pagination from './Pagination.vue'

export default {

    components: {
        QuestionItem,
        Pagination
    },

    data () {
        return {
            questions: [],
            meta: {},
            links: {}
        }
    },

    //  ライフサイクルフックのmountedはブラウザからページにアクセスした際に自動で処理させたいことを記述する場所ということ
    mounted () {
        this.fetchQuestions()
    },

    methods: {
        fetchQuestions () {
            axios.get('/questions', { params: this.$route.query })
                .then(({ data }) => {
                    this.questions = data.data
                    this.meta = data.meta;
                    this.links = data.links
                })
        },

        remove (index) {
            this.questions.splice(index, 1)
            this.count--
        }
    },

    watch: {
        "$route": 'fetchQuestions'
    }
}
</script>