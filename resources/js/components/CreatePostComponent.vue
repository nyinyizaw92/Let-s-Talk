<template>
    <div class="post-create">
        <h2>Create Post</h2>

        <form @submit.prevent="addPost(userid)">
            <div class="post-title">
                <label for="title">Title</label>
                <input type="text" v-model="post.title" placeholder="enter title" id="title">
            </div>

             <div class="post-content">
                <label for="content">Content</label>
                <vue-editor v-model="post.content" id="content" />
            </div>
            
            <div class="post-category">
                <label for="category">Categroy</label>
                <select id="category" class="form-control" v-model="post.category_id">
                    <option value="">Choose Category</option>
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
    props:['categories','user'],

    data(){
        return{
            userid : this.user,
            post : {
                title:'',
                content:'',
                category_id:'',
            },
            imageData: ""
        }
    },

    methods:{
        addPost:function(userid){
            let data = new FormData();
            data.append('user_id',userid);
            data.append('title',this.post.title);
            data.append('content',this.post.content);
            data.append('category_id',this.post.category_id);
            
            // if(document.getElementById('image').files[0]){
                
            //     data.append('image',document.getElementById('image').files[0]);
                
            //     var image  = document.getElementById('image').files[0];
            //     console.log(image);
            //     var reader = new FileReader();
            //     reader.onload = function()
            //     {
            //     var output = document.getElementById('add-image');
            //     output.src = reader.result;
            //     }
            //     reader.readAsDataURL(image);
            // }

            axios.post('/post',data)
            .then((response)=>{
                window.location.href = '../';
            })
            .catch(error=>this.form.errors.record(error.response.data));
        },

        previewImage: function(event) {
            // Reference to the DOM input element
            var input = event.target;
            // Ensure that you have a file before attempting to read it
            if (input.files && input.files[0]) {
                console.log('ol0');
                // create a new FileReader to read this image and convert to base64 format
                var reader = new FileReader();
                // Define a callback function to run, when FileReader finishes its job
                reader.onload = (e) => {
                    // Note: arrow function used here, so that "this.imageData" refers to the imageData of Vue component
                    // Read image as base64 and set to imageData
                    this.imageData = e.target.result;
                }
                // Start the reader job - read file as a data url (base64 format)
                reader.readAsDataURL(input.files[0]);
            }
        }
    }
}
</script>