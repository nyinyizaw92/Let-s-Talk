<template>
    <div class="post-edit">
         <h2>Edit Post</h2>

        <form @submit.prevent="editPost(post.id)">
            <div class="post-title">
                <label for="title">Title</label>
                <input type="text" v-model="editpost.title" id="title">
            </div>

             <div class="post-content">
                <label for="content">Content</label>
                <vue-editor  id="content" v-model="editpost.content" />
            </div>
            
            <div class="post-category">
                <label for="category">Categroy</label>
                <select id="category" class="form-control" v-model="editpost.category_id">
                    <option :value="editpost.category_id">{{post.category.title}}</option>
                    <option :key="category.id" v-for="category in this.categories" :value="category.id">{{category.title}}</option>
                </select>
            </div>
       
           <!-- <div class="post-image">
                <label for="image">Images</label>
                <input type="file" id="image" @change="previewImage">

                <div class="add-image" v-if="imageData.length > 0">
                    <img id="add-image" :src="imageData"/>
                </div>
            </div> -->

            <div class="post-save">
                <div class="cancle">
                    <input type="reset" value="Cancel" class="remove_preview"/>
                </div> 
                <div class="save">
                    <input type="submit" value="Post"/>
                </div> 
            </div>
        </form>
    </div>
</template>
<script>
export default {
    props:[ 'posts','categories'],
    data(){
        return{
            post : this.posts,
            category : this.categories,

            editpost : {
                title : this.posts.title,
                content : this.posts.content,
                category_id : this.posts.category.id, 
            }
        }
    },
    methods:{
        editPost:function(id){
            let data = new FormData();
            data.append('title',this.editpost.title);
            data.append('content',this.editpost.content);
            data.append('category_id',this.editpost.category_id);

            axios.post('/post/'+ id ,{_method: 'put', 
            'title':this.editpost.title,
            'content':this.editpost.content,
            'category_id':this.editpost.category_id
            })
            .then((response)=>{
                console.log(response);
                window.location.href = '/';
            })
            .catch(error=>this.form.errors.record(error.response.data));
        }
    }
}
</script>