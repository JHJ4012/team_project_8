<template>
<div class="item2">
        <form @submit = "postQnA">
            <input type="text" id="form_control" placeholder="제목" style="color: #fff; font-size: 24px" maxlength="100" v-model = "title">
            <textarea id="form_control2" placeholder="내용"  maxlength="2048" style="height: 400px; color: #fff" v-model = "question"></textarea>
            <br/>
            <button class="ok">완료</button>
            <button v-on:click="back">취소</button>
        </form>
    </div>
</template>

<script>
export default {
    mounted() {
        if(this.$route.params.title && this.$route.params.question){
            this.title = this.$route.params.title
            this.question = this.$route.params.question
        }
    },
    data(){
        return {
            title : '',
            question : ''
        }
    },
    methods : {
        postQnA(e) {
            e.preventDefault(); //선택된 요소의 기본 동작을 실행하는 것을 막음
            let currentObj = this;
            if(this.$route.params.title && this.$route.params.question){
                Axios.patch('/api/qna/' + this.$route.params.id, {
                    title: this.title, 
                    question : this.question
                })
                .then(response => {
                    this.$router.push('/qna')
                })
                .catch(error => {
                    console.log(error)
                });
            }
            else{
                Axios.post('/api/qna',{
                    control : 'qna',
                    title : this.title,
                    question : this.question
                })
                .then(response => {
                    console.log(response.data.msg)
                    this.$router.push('/qna')
                })
                .catch(error => {
                    console.log(error)
                });
            }
        },
        back(){
            this.$router.push('/qna')
        }
    }
}
</script>

<style scoped>
.item2 {
    margin-top: 13%;
    margin-left: 30%;
    color: #fff;
}

#create {
    text-align: center;
    margin-top: 13%;
    margin-left: 30%;
    border: 0px solid transparent;
}

.item2 button {
    cursor: pointer;
    color: white;
    background-color: transparent;
    border: 0px;
    border-bottom: 2px solid white;
   font-size: 15px;
    margin-top: 1%;
    font-size: 17px;
    margin-left: 5%;
}

.item2 .ok {
    margin-left: 23%;
}

#form_control{
    margin-top: 20px;
    padding-bottom: 1%;
    width:600px;
    border: 0px solid transparent;
    border-bottom: 2px solid #fff;
    background-color: transparent;
}
#form_control2{
    margin-top: 10px;
    width:600px;
    border: 2px solid #fff;
    background-color: transparent;
}
</style>