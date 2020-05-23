<template>
    <div class="popular-post">
        <div class="post-list" :key="popular_post.id" v-for="popular_post in this.popular_posts">
            <a :href="`/post/show/${popular_post.id}`">
                <div class="post-header">
                    <h3>{{popular_post.title}}</h3>
                    <p v-html="popular_post.content.substring(0,50) + ' ...'" v-if="popular_post.content.length > 50"></p>
                    <p v-else v-html="popular_post.content"></p>
                </div>
            </a>
        </div>
    </div>
</template>
<script>
export default {
    props:['popular_posts'],
}
</script>