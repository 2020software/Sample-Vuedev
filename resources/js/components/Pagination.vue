<template>
    <div class="row align-items-center">
        <div class="col text-left">
            <button :disabled="isFirst" @click="prev" class="btn btn-outline-secondary">戻る</button>
        </div>
        <div class="col text-center">
            {{ pagesInfo }}
        </div>
        <div class="col text-right">
            <button :disabled="isLast" @click="next" class="btn btn-outline-secondary">次へ</button>
        </div>
    </div>
</template>

<script>
export default {
    // Questions.vueからprops
    props: ['meta', 'links'],   // meta はページの情報やURL

    // ページ数の操作は算出プロパティなのでcomputed
    computed: {
        pagesInfo () {
            return `${this.meta.current_page} / ${this.meta.last_page}`
        },

        isFirst () {
            return this.meta.current_page === 1
        },
        
        isLast () {
            return this.meta.current_page === this.last_page
        }
    },

    methods: {
        switchPage () {
            this.$router.push({
                name: 'questions',
                query: {
                    page: this.meta.current_page
                }
            })
        },

        prev () {
            if (! this.isFirst) {
                this.meta.current_page--
            }
            this.switchPage()
        },

        next () {
            if (! this.isLast) {
                this.meta.current_page++
            }
            this.switchPage()
        }
    }
}
</script>