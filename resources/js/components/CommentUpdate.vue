<template>
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h3>Comment Update</h3>
        </div>
        <div class="modal-body">
            <form @submit.prevent="updateCmt(id)">
                <vue-editor v-model="update"></vue-editor>
                <input type="submit" value="Update">
            </form> 
        </div>
    </div>
</template>
<script>
export default {
    props:['ans','cmtid','text'],
    data(){
        return{
            id:this.cmtid,
            url:this.text,
            update:this.ans
        }
    },
    methods:{
        updateCmt:function(id){
            if(this.url == "commentUpd"){
                axios.post('/comment/'+id,{_method:'put','answer':this.update})
                .then((response)=> window.location.reload())
                .catch((error) => console.log(error))
            }else if(this.url == "repcommentUpd"){
                axios.post('/reply-comment/'+id,{_method:'put','answer':this.update})
                .then((response)=> window.location.reload())
                .catch((error) => console.log(error))
            }
        }
    }
}
</script>