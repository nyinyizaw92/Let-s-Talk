/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Form from './Form';
import Vue2Editor from "vue2-editor";

window.Form = Form;
Vue.use(Vue2Editor);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('latest-post-display',require('./components/LatestPostDisplay.vue').default);
Vue.component('user-vote-post',require('./components/UserVotePostComponent.vue').default);
Vue.component('post-edit-delete',require('./components/PostEditDeleteComponent.vue').default);
Vue.component('create-post',require('./components/CreatePostComponent.vue').default);
Vue.component('edit-post',require('./components/EditPost').default);
Vue.component('popular-post',require('./components/PopularPost').default);
Vue.component('top-user',require('./components/TopUser').default);
Vue.component('post-detail',require('./components/PostDetail').default);
Vue.component('show-comment',require('./components/ShowComment').default);
Vue.component('reply-comment',require('./components/ReplyComment').default);
Vue.component('update-comment',require('./components/CommentUpdate').default);
Vue.component('other-question',require('./components/OtherQuestion').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
