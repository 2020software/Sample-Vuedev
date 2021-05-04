export default {
    // 編集. 削除. その他
    modify (user, model) {
        return user.id === model.user.id;
    },

    // ベストアンサー
    accept (user, answer) {
        return user.id === answer.question_user_id;
    },

    deleteQuestion (user, question) {
        return user.id === question.user.id && question.answers_count < 1;
    }
}