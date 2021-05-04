<template>
    <div class="container">
        <div class="jumbotron text-center">
            <h1 class="display-4">ページが見つかりません</h1>
            <p class="lead">お探しのページが見つかりません</p>
            <hr class="my-4">
            <router-link :to="{ name: 'home' }" class="btn btn-primary btn-lg">ホームへ戻る</router-link>
        </div>
    </div>
</template>