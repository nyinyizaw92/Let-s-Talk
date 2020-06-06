<template>
    <div>
        <div class="answer-comment" :key="cmt.id" v-for="(cmt,index) in comment">
            <div class="answer">
                <div class="comment-user">
                    <img :src="`/profile/${cmt.user.profile}`" alt="user_profile" v-if="cmt.user.profile !== null"/>
                    <img src="/icons/icons8-male-user-50.png" alt="user_profile" v-else/>
                    <span>{{cmt.user.name}}</span>
                </div>

                <div class="comment-answer" v-html="cmt.answer"></div>

                <div class="comment-edit">
                     <div class="reply">
                        <div class="reply-img" @click="replyCmt = index">
                            <img src="/icons/icons8-reply-arrow-30.png" alt="reply"> 
                            <span>{{cmt.replycomment.length}}</span>
                        </div>
                    
                        <div class="edit" v-if="authid == cmt.user_id">
                            <button class="edit-btn" @click="commentUpdate = index">Edit</button>
                        </div>

                        <div class="delete"  v-if="authid == cmt.user_id">
                            <form @submit.prevent="delCmt(cmt.id)">
                            <input type="submit" value="Delete">
                        </form>
                        </div>
                        
                    </div>
                </div>

                <div class="update-form" v-show="commentUpdate == index">
                    <UpdateComment :ans="cmt.answer" :cmtid="cmt.id" text="commentUpd"/>
                </div>

                <div class="reply-box" v-show="replyCmt == index">
                    <ReplyCmt :commentreply="cmt.replycomment" :userid="authid"/>
                    <form @submit.prevent="addReplyComment(cmt.id,cmt.post_id,authid)">
                        <vue-editor v-model="replycomment.answer" id="answer" />
                        <input type="reset" value="cancle" @click="canclement()">
                        <input type="submit" value="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ReplyCmt from './ReplyComment';
import UpdateComment from './CommentUpdate'
export default {
    props:['postcomment','auth'],
    data(){
        return{
            comment: this.postcomment,
            authid : this.auth,
            replyCmt : -1,
            commentUpdate : -1,
            replycomment:{
                answer:'',
            }
        }
    },
    components:{
        ReplyCmt,
        UpdateComment
    },
    methods:{
        delCmt:function(id){
            axios.post('/comment/'+id,{_method:'delete'})
            .then((response)=>{
                console.log(response);
                window.location.reload();
            })
            .catch(error=>this.form.errors.record(error.response.data));
        },

        canclement:function(){
            this.replycomment.answer = '',
            this.replyCmt = -1
        },

        addReplyComment:function(cmtid,post_id,user_id){
            if(user_id == 0){
                window.location.href="/login";
            }

            let data = new FormData();
            data.append('post_id',post_id);
            data.append('user_id',user_id);
            data.append('comment_id',cmtid);
            data.append('answer',this.replycomment.answer);

            axios.post('/reply-comment',data)
            .then((response)=>{
               window.location.reload();
            })
            .catch(error=>console.log(error));
        },
    }
}
</script>