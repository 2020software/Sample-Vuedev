<answer :answer="{{ $answer }}" inline-template>
    <div class="media post">
        <vote :model="{{ $answer }}" name="answer"></vote>
        <div class="media-body">
            <!-- 編集中 -->
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea class="form-control" v-model="body" rows="10" required></textarea>
                </div>
                <button class="btn btn-primary" :disabled="isInvalid">更新</button>
                <button class="btn btn-outline-secondary" type="button" @click="cancel">キャンセル</button>
            </form>
            <div v-else>
                <!-- 編集していないとき -->
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            @can ('update', $answer)
                                <a @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                            @endcan
                            @can ('delete', $answer)
                                <button @click="destroy" type="submit" class="btn btn-sm btn-outline-danger">削除</button>
                            @endcan
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <user-info :model="{{ $answer }}" label="Answerd"></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</answer>