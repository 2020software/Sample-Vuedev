<template>
    <!-- v-ifで質問の存在を確かめないとエラー -->
    <div class="container" v-if="question.id">
        <question :question="question"></question>
        <answers :question="question"></answers>
    </div>
</template>

<script>
import Question from '../components/Question.vue';
import Answers from '../components/Answers.vue';

export default {
    components: { Question, Answers },

    props: ['slug'],    // QuestionItemのrouter-linkから

    data () {
        return {
            question: {
                title: '',
                body: '',
                id: ''
            }
        }
    },

    mounted () {
        // 質問取得
        this.fetchQuestion()
    },

    methods: {
        fetchQuestion () {
            axios.get(`/questions/${this.slug}`)
                .then(({ data }) => {
                    this.question = data.data
                })
                .catch(error => console.log(error))
        }
    }
}
</script>