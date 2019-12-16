<template>
    <div class="body">
        <div class="login_all">
            <div class="login">
                <p>로그인</p>
                <form @submit = "postLogin">
                    <div class="form-group">
                        <div class="col-lg-8">
                            <input type="text" class="form-control" v-model="user_id" placeholder="ID" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-8">
                            <input type="password" class="form-control" v-model="password" placeholder="비밀번호" required>
                        </div>
                    </div>
                    <div class="message">
                        {{ message }}
                    </div>
                    <div class="form-group">
                        <button>확인</button>
                        <button v-on:click="back">취소</button>
                    </div>   
                </form>
            </div>
            <div class="new">
                <a href="">ID 찾기</a> | <router-link to = "/join"><a href="/../join">아직 회원이 아니신가요?</a></router-link>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    mounted() {
            console.log('Component mounted.')
        },
    data() {
        return{
            user_id : '',
            password : '',
            message : ''
        }
    },
    methods : {
        postLogin(e) {
            e.preventDefault(); //선택된 요소의 기본 동작을 실행하는 것을 막음
            let currentObj = this;
            console.log(this.user_id)
            console.log(this.password)
            Axios.post('/api/login',{
                user_id : this.user_id,
                password : this.password,
            })
            .then(response => {
                console.log($cookies.isKey('_token'))
                window.location.href = '/';
            })
            .catch(error => {
                this.message = '아이디와 비밀번호를 확인해 주세요'
                console.log(error)
            });
        },
        back(){
            this.$router.push('/')
        }
    }
}
</script>

<style scoped>
.body {
    padding-top: 14%;
    padding-bottom: 13.6%;
    background-image: url("/image/office.jpg");
    height: 500%;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

.login_all {
    /* margin-top: 14%; */
    margin-right: 35%;
    margin-left: 35%;
    padding-bottom: 2%;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.6);
    border-radius: 10px;
    border : 1px solid white;
}

.login {
    margin-top: 15%;
    color: white;
}

.login p {
    text-align: center;
    font-size: 24px;
    font-weight: 500;
    padding-top: 4%;
    padding-bottom: 5%;
}

.message {
    color: #ff7066;
    font-size: 14px;
}

.user {
    margin-top: 1.5%;
    margin-bottom: 1%;
}

#login_pw {
    margin-top: 3%;
    margin-bottom: 3%;
}

#login_id,
#login_pw {
    color: #fff;
    background-color: transparent;
    border: 0 solid transparent;
    border-bottom: 1px solid #fff;
    width: 44%;
    text-align: center;
}

.new {
    margin-top: 5%;
    text-align: center;
    color: white;
}

.new a {
    color: white;
    text-decoration: none;
    font-size: 13px;
}

#login_ok {
    background-color: #cfcfcf;
    border: 1px solid white;
    margin: 0.2%;
}

.form-group input {
    color: #fff;
    background-color: transparent;
    border: 0 solid transparent;
    border-bottom: 1px solid #fff;
    width: 44%;
    text-align: center;
    padding-top: 1%;
    margin-top: 1.5%;
    margin-bottom: 1%;
}

.form-group input::placeholder {
    color: #fff;
    font-size: 15px;
}

.form-group button {
    width: 215px;
    height: 27px;
    border-radius: 5px;
    background-color: darkgray;
    color: black;
    cursor: pointer;
    margin-top: 5%;
}

</style>