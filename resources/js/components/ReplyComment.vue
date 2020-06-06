<template>
    <div>
        <div class="comment-user" :key="repcmt.id" v-for="(repcmt,index) in replyComments">
            <p>{{repcmt.user_id}}</p>
           
            <div v-html="repcmt.answer"></div>
            <div class="reply-comment-edit" v-if="user_id == repcmt.user_id">
                <div class="reply-edit">
                    <button class="edit-btn" @click="updatereply = index">Edit</button>
                </div>
                <div class="reply-delete">
                    <form @submit.prevent="repdelCmt(repcmt.id)">
                        <input type="submit" value="Delete" class="delete-form">
                    </form>
                </div>
            </div>
             <div class="update-reply-form" v-show="updatereply == index">
                <UpdateComment :ans="repcmt.answer" :cmtid="repcmt.id" text="repcommentUpd"/>
            </div>
        </div>
    </div>
</template>
<script>
import UpdateComment from './CommentUpdate';
export default {
    props : ['commentreply','userid'],
    data(){
        return{
            replyComments:this.commentreply,
            user_id : this.userid,
            userdata : [],
            updatereply: -1,
        }
    },
    components:{
        UpdateComment
    },
    methods:{
        repdelCmt:function(id){
            axios.post('/reply-comment/'+id,{_method:'delete'})
            .then((response)=>{
                window.location.reload();
            })
            .catch(error=>console.log(error));
        },
    },

    
}
</script>