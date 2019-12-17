<template>
    <div>
        <div id="all">
            <div class="navi_title">
                <a href="/">8</a>
            </div>
            <div class="navi">
                <div id="navibar">
                    <a href="/member">조원소개</a>
                    <a href="/japan">현지학기제</a>
                    <a href="/qna">QnA</a>
                </div>
        </div>
            
        </div>
        <div class="navilog" id="navilog">
            <a href="#"  @click="logout" v-if="token_exist == true">로그아웃</a>
            <a href="/login" v-if="token_exist == false">로그인</a>
        </div>
    </div>

</template>

<script>
    export default {
        mounted() {
            //
        },
        data(){
            return{
                token_exist : $cookies.isKey('_token')
            }
        },
        methods : {
            logout(){
                Axios.get('/api/logout')
                .then(response=>{
                    console.log(response)
                    this.$router.go(0)
                })
                .catch(error => {
                    console.log(error)
                })
            }
        },
    }
</script>