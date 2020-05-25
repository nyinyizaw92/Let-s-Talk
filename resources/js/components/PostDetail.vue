<template>
    <div class="post-detail">
        <div class="post">
            <div class="user-info">    
                <div class="profile">
                     <img src="/icons/icons8-male-user-50.png" alt="profile" v-if="post_detail.user.profile == null">
                     <img :src="`/profile/${post_detail.user.profile}`" alt="profile" v-else >
                </div>
                <div class="name">
                    <p><i>{{post_detail.user.name}}</i></p>
                </div>
            </div>
            <div class="post-info">
                <div class="like-comment">
                    <div class="like">
                        <div v-if="userid !==0">  
                            <img src="/icons/icons8-heart-outline-24.png" alt="vote" v-if="post_detail.like_count == 0">

                            <div :key="like.id" v-for="like in post_detail.userlike">
                                <img src="/icons/icons8-heart-outline-24-blue.png" alt="vote" v-if="like.user_id == userid"
                                    style="z-index:1">  
                                    
                                <img src="/icons/icons8-heart-outline-24.png" alt="vote" v-else> 
                            </div>

                            <form @submit.prevent="userpostlike(post_detail.id,userid)">
                                <input type="submit">
                            </form>
                            
                            <p>{{post_detail.like_count}}</p>
                        </div>
                        <div v-else> 
                            <img src="/icons/icons8-heart-outline-24.png" alt="vote" @click="likepost(post_detail.id)">
                            <p>{{post_detail.like_count}}</p>
                        </div>
                    </div>
                    <div class="comment">
                        <img src="/icons/icons8-comments-24.png" alt="comment">
                        <p >{{post_detail.comment_count}}</p>
                    </div>
                </div>
                <div class="detail-post">
                    <h3>{{post_detail.title}} <span>{{post_detail.category.title}}</span></h3>
                    <div v-html="post_detail.content"></div>
                </div>
            </div>
            <show-comment :postcomment="this.comments" :auth="userid"></show-comment>
            <div class="comment-box">
                <form @submit.prevent="addComment(post_detail.id,userid)">
                    <vue-editor v-model="comment.answer" id="answer" />
                    <input type="reset" value="cancle" @click="comment.answer = ''">
                    <input type="submit" value="submit">
                </form>
            </div>

            
        </div>
    </div>
</template>
<script>
export default {
    props:['postdetail','user','comments'],

    data(){
        return{
            post_detail : this.postdetail,
            userid : this.user,
            
            comment : {
                answer:'',
            }
        }
    },

    methods:{
        likepost:function(id){
             window.location.href = '/login';
        
        },

        userpostlike:function(post_id,user_id){
            
           axios.post('/post-like',{user_id:user_id ,post_id: post_id})
            .then((response)=>{
                 window.location.reload();
            })
            .catch(error=>this.form.errors.record(error.response.data));
        },

        addComment:function(post_id,user_id){
            if(user_id == 0){
                window.location.href="/login";
            }
            let data = new FormData();
            data.append('user_id',user_id);
            data.append('post_id',post_id);
            data.append('answer',this.comment.answer);

            axios.post('/comment',data)
            .then((response)=>{
               window.location.reload();
            })
            .catch(error=>this.form.errors.record(error.response.data));
        }

        
    },
}
</script>