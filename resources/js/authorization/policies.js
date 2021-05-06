export default {
    // 編集. 更新
    modify (user, model) {
        return user.id === model.user.id;
    },

    // ベストアンサー
    accept (user, answer) {
        return user.id === answer.question_user_id;
    },

    deleteQuestion (user, question) {
        // 回答が0の質問のみ削除可能
        return user.id === question.user.id && question.answers_count < 1;
    }
}