export default {
    // 編集. 更新. 削除 | model = Answer, Question
    modify (user, model) {
        return user.id === model.user.id;
    },

    // ベストアンサー
    accept (user, answer) {
        return user.id === answer.question_user_id;
    },

    // 回答がすべてなくなってから質問も削除できるので、 modify とはまた別
    deleteQuestion (user, question) {
        // 回答が0の質問のみ削除可能
        return user.id === question.user.id && question.answers_count < 1;
    }
}