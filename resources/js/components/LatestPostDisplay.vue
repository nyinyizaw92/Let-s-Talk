<template>
    <div>
        <div :key="post.id" v-for="(post,index) in this.posts">
           
           <div class="post">
               <div class="user-profile" v-if="post.user.profile == null">
                    <img src="/icons/icons8-male-user-50.png" alt="profile">
                </div>
                <div v-else class="user-profile">
                    <img :src="`/profile/${post.user.profile}`" alt="profile" >
                </div>

                <div class="post-list">
                    <a :href="`/post/show/${post.id}`">
                        <div class="post-header">
                            <h3>{{post.title}}</h3>
                            <p v-html="post.content.substring(0,50) + ' ...'"  v-if="post.content.length > 50"></p>
                            <p v-else v-html="post.content"></p>
                            <!-- {{post.content.substr(0, 35)}}..... -->
                        </div>
                    </a>

                    <div class="post-body">
                        <div class="comment-vote">
                            <div class="comment">
                                <img src="/icons/icons8-comments-24.png" alt="comment" class="comment-box">
                                <!-- @click="addComment = index" -->
                                <span>{{post.comment_count}}</span>
                            </div>

                            <div class="vote">
                                <div v-if="userid !==0">  
                                    <img src="/icons/icons8-heart-outline-24.png" alt="vote" v-if="post.like_count == 0">

                                    <div :key="like.id" v-for="like in post.userlike">
                                         <img src="/icons/icons8-heart-outline-24-blue.png" alt="vote" v-if="like.user_id == userid"
                                                style="z-index:1">  
                                            
                                        <img src="/icons/icons8-heart-outline-24.png" alt="vote" v-if="like.user_id !== userid"> 
                                    </div>

                                    <form @submit.prevent="userpostlike(post.id,userid)">
                                        <input type="submit">
                                    </form>
                                   
                                    <span>{{post.like_count}}</span>
                                </div>
                                <div v-else> 
                                    <img src="/icons/icons8-heart-outline-24.png" alt="vote" @click="likepost(post.id)">
                                    <span>{{post.like_count}}</span>
                                </div>
                            </div>
                        </div>

                        <div v-if="userid !==0 && post.user_id == userid">
                            <PostEditDelete  :post_id="post.id"/>
                        </div>
                    </div>

                    <div v-show="addComment == index" class="add-comment">
                        <slot :postid="post.id">{{post.id}}</slot>
                    </div>

                  
                  
                </div>
           </div>

         
        </div>
    </div>
</template>
<script>
import PostEditDelete from './PostEditDeleteComponent';
export default {
    props:['posts','user'],

    components: {
        PostEditDelete
    },

    data(){
        return {
            addComment: -1,
            userid : this.user,
        }  
    },

    methods:{
        likepost:function(id){
             window.location.href = '/login';
        
        },

        userpostlike:function(post_id,user_id){
            
           axios.post('./post-like',{user_id:user_id ,post_id: post_id})
            .then((response)=>{
                 window.location.href = '../';
            })
            .catch(error=>this.form.errors.record(error.response.data));
        },

        
    },

    mounted:function(){
        
    }
   
}
</script>