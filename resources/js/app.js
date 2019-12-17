require('./bootstrap');

window.Vue = require('vue');

window.VueRouter=require('vue-router').default;

window.VueAxios=require('vue-axios').default;

window.Axios=require('axios').default;

window.VueCookies=require('vue-cookies').default;

Vue.use(VueRouter, VueAxios, axios,VueCookies);

Vue.component('pagination', require('laravel-vue-pagination'));

import Parent from './components/App'
import Main from './components/MainComponent'
import Login from './components/LoginComponent'
import Join from './components/JoinComponent'
// import Member from './components/MemberComponent'

//바뀐부분
import MemberList from './components/MemberList'
import MemberCreate from './components/MemberCreate'
import MemberUpdate from './components/MemberUpdate'
//
import Japan from './components/JapanComponent'
import QnAList from './components/QnAList'
import QnACreate from './components/QnACreate'
import QnAView from './components/QnAView'
import JapanModify from './components/JapanModifyComponent.vue'
import JapanCreate from './components/JpnCreateComponent.vue'

const router = new VueRouter({
    mode : 'history',
    routes : [
        {
            path : '/',
            name : 'Main',
            component : Main
        },
        {
            path : '/login',
            name : 'Login',
            component : Login
        },
        {
            path : '/join',
            name : 'Join',
            component : Join
        },
        //바뀐부분
        {
            path : '/member', // 목록 출력하기
            name : 'MemberList',
            component : MemberList
        },
        {
            path : '/member/create', // 생성하기
            name : 'MemberCreate',
            component : MemberCreate,
            props : true    //파라미터 받을 수 있게 설정
        },
        {
            path : '/member/update', // 수정하기
            name : 'MemberUpdate',
            component : MemberUpdate,
            props : true
        },
        //
        // {
        //     path : '/member',
        //     name : 'Member',
        //     component : Member
        // },
     
        {
            path : '/japan',
            name : 'Japan',
            component : Japan
        },
        {
            path : '/japan/create',
            name : 'JapanCreate',
            component : JapanCreate
        },
        {
            path : '/japan/modify',
            name : 'JapanModify',
            component : JapanModify
        },
        {
            path : '/qna',
            name : 'QnAList',
            component : QnAList
        },
        {
            path : '/qna/create',
            name : 'QnACreate',
            component : QnACreate
        },
        {
            path : '/qna/view',
            name : 'QnAView',
            component : QnAView,
            props : true
        }
    ]
});

const app = new Vue({
    el : '#app',
    router,
    render : (h) => h(Parent)
});

Vue.prototype.$EventBus = new Vue();    //컴포넌트간 통신을 하기 위해서
