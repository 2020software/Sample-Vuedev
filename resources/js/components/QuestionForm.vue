<template>
    <form @submit.prevent="handleSubmit">
        <div class="form-group">
            <label for="question-title">質問のタイトル</label>
            <input type="text" name="title" :class="errorClass('title')" v-model="title">

            <div v-if="errors['title'][0]" class="invalid-feedback">
                <strong>{{ errors['title'][0] }}</strong>
            </div>
        </div>
        <div class="form-group">
            <label for="question-body">質問の内容</label>
            <textarea name="body" rows="10" :class="errorClass('body')" v-model="body"></textarea>

            <div v-if="errors['body'][0]" class="invalid-feedback">
                <strong>{{ errors['body'][0] }}</strong>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-outline-primary btn-lg">{{ buttonText }}</button>
        </div>
    </form>
</template>

<script>
import EventBus from '../event-bus'
export default {
    props: {
        isEdit: {
            type: Boolean,
            default: false
        }
    },
    data () {
        return {
            title: '',
            body: '',
            errors: {
                title: [],
                body: []
            }
        }
    },

    mounted () {
        //  CreateQuesitonからのエラーメッセージを受け取る
        EventBus.$on('error', errors => this.errors = errors)

        // 質問を編集しているなら
        if (this.isEdit) {
            this.fetchQuestion()
        }
    },


    // computed = {{ buttonText }}
    // 動的に表示するのでcomputedで表示
    computed: {
        buttonText () {
            return this.isEdit ? '質問を更新' : '質問する'
        }
    },

    methods: {
        fetchQuestion () {
            axios.get(`/questions/${this.$route.params.id}`)
                .then(({ data }) => {
                    // 存在していたタイトル、本文を上書き
                    this.title = data.title
                    this.body = data.body
                })
                .catch(error => {
                    console.log(error.response)
                })
        },
        handleSubmit () {
            //  CreateQuestion.vueが親コンポ
            this.$emit('submitted', {
                title: this.title,
                body: this.body
            })
        },

        errorClass (column) {
            return [
                'form-control',
                this.errors[column] && this.errors[column][0] ? 'is-invalid' : ''
            ]
        }
    }
}
</script>