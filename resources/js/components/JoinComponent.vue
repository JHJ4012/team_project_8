<template>
    <div class="all">
        <div class="body">
            <div class="join_all">
                <div class="join">
                    <p>회원가입</p>
                    <form @submit = "postUser">
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

                        <div class="form-group">
                            <div class="col-lg-8">
                                <input type="text" class="form-control" v-model="name" placeholder="이름" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-8">
                                <input type="email" class="form-control" v-model="email" placeholder="email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-8">
                                <input type="text" class="form-control" v-model="sex" placeholder="성별" required>
                            </div>
                        </div>
                        <div class="message">
                            {{ message }}
                        </div>
                        <div class="form-group">
                            <button>가입</button>
                            <button v-on:click="back">취소</button>
                        </div>   
                    </form>
                </div>
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
            name : '',
            email : '',
            sex : '',
            message : '',
        }
    },
    methods : {
        postUser(e) {
            e.preventDefault(); //선택된 요소의 기본 동작을 실행하는 것을 막음
            let currentObj = this;
            Axios.post('/api/join',{
                user_id : this.user_id,
                sex : this.sex,
                name : this.name,
                email : this.email,
                password : this.password,
            })
            .then(response => {
                console.log(response)
                if(response.data.error === '1') {
                    this.message = '아이디가 중복됩니다.'
                }else if(response.data.error === '2') {
                    this.message = '이메일이 중복됩니다.'
                }else{
                    alert('회원가입되었습니다.')
                    this.$router.push('/login')
                }
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
    padding-bottom: 9.7%;
    background-image: url("/image/office.jpg");
    height: 500%;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

.join_all {
    /* margin-top: 14%; */
    margin-right: 35%;
    margin-left: 35%;
    padding-bottom: 2%;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.6);
    border-radius: 10px;
    border : 1px solid white;
}

.join {margin-top: 15%;color: #fff}

.join p {text-align: center;font-size: 24px;font-weight: 500;padding-top: 4%;padding-bottom: 5%}

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

.message {
    color: #ff7066;
    font-size: 14px;
}
</style>