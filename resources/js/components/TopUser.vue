<template>
    <div>
        <div class="top" :key="top_user.id" v-for="top_user in this.top_users">
            <div class="user-profile">
                <img src="/icons/icons8-male-user-50.png" alt="profile" v-if="top_user.profile == null"> 

                <img :src="`/profile/${top_user.profile}`" alt="profile" v-else>
            </div>

            <div class="post-list">
                <a href="#">
                    <div class="post-header">
                        <h3>{{top_user.name}}</h3>

                    </div>
                </a>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props : ['top_users']
}
</script>