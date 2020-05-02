<template>
    <div class="edit-delete">
        <div class="edit">
        <a :href="`/post/${this.post_id}/edit`">Edit</a>
        </div>
        <div class="delete">
            <form @submit.prevent="postDelete()">
                <input type="submit" value="Delete">
            </form>
        </div>    
    </div>            
</template>
<script>
export default {
    props : ['post_id'],
    methods:{
        postDelete:function(){
            axios.post('/post/'+this.post_id,{_method: 'delete'})
        //    axios.delete('/post',{params: {id: this.post_id}})
            .then((response)=>{
                console.log(response);
                window.location.href = '../';
                window.location.reload();
            })
            .catch(error=>this.form.errors.record(error.response.data));
        }
    }
}
</script>

