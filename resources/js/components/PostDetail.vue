<template>
    <div class="post-detail">
        <div class="post">
            <div class="user-info">    
                <div class="photo">
                     <img src="/icons/icons8-male-user-50.png" alt="up" v-if="post_detail.user.profile == null">
                     <img :src="`/profile/${post_detail.user.profile}`" alt="up" v-else>
                </div>
                <div class="name">
                    <p><i>{{post_detail.user.name}}</i></p>
                </div>
            </div>
            <div class="post-info">
                <div class="like-comment">
                    <div class="like">
                        <div v-if="userid !==0">  
                            <img src="/icons/icons8-heart-outline-24.png" alt="vote" 
                            v-if="post_detail.like_count == 0" 
                            @click="userpostlike(post_detail.id,userid)">

                            <div :key="like.id" v-for="like in post_detail.userlike" 
                                @click="userpostlike(post_detail.id,userid)"
                                v-else>
                                <img src="/icons/icons8-heart-outline-24-blue.png" 
                                alt="vote" v-if="like.user_id == userid"
                                style="z-index:1;
                                ">  
                                
                                 <img src="/icons/icons8-heart-outline-24.png" alt="vote"
                                  v-else />
                               
                            </div>
                        
                            
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
                    <div class="save"  @click="savepost(post_detail.id,userid)">
                        <img src="/icons/icons8-bookmark-30-color.png" alt="save" v-if="saveuser">
                        <img src="/icons/icons8-bookmark-30.png" alt="save" v-else>
                        
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
        <OtherQuestion :otherpost="post_detail"/>
    </div>
</template>
<script>
import OtherQuestion from './OtherQuestion'
export default {
    props:['postdetail','user','comments'],
    components:{
        OtherQuestion
    },
    data(){
        return{
            post_detail : this.postdetail,
            userid : this.user,
            saveuser : '',
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
        },

        savepost:function(postid,userid){
            if(userid === 0){
                window.location.href="/login";
            }else{
                let data = new FormData();
                data.append('user_id',userid);
                data.append('post_id',postid);
                 axios.post('/save-post/',data)
                .then((response) =>window.location.reload())
                .catch((error) => console.log(error))
            }
           
        }
    },

    mounted:function(){
        
        if(this.userid !== 0 ){
             axios.get('/save-post/'+this.post_detail.id)
            .then((response) => 
                response.data.forEach( a => {
                        if(a.user_id == this.userid){
                            this.saveuser = a.user_id
                        }
                    }
                )
            )
            .catch((error) => console.log(error));
        }
    }


}
</script>