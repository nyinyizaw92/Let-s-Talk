<template>
    <div class="other">
        <h3>Problem in {{relativePost.category.title}}</h3>
        <div class="problem" v-for="problem in otherPost" :key="problem.id">
            <div class="data" v-if="problem.id !== relativePost.id">
                <a :href="`/post/show/${problem.id}`">
                    <h4>{{problem.title}}</h4>
                </a>
                <p v-html="problem.content.substring(0,50) + ' ...'"  v-if="problem.content.length > 50"></p>
                <p v-else v-html="problem.content"></p>
            </div>   
        </div>
    </div>
</template>
<script>
export default {
    props:['otherpost'],
    data(){
        return{
            relativePost:this.otherpost,
            otherPost:[]
        }
    },
    mounted:function(){
        axios.get('/api/v1/post/'+this.relativePost.category_id)
            .then((response) => this.otherPost = response.data)
            .catch((error) => console.log(error));
    }
}
</script>