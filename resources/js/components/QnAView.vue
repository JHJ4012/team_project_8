<template>
    <div class="item2">
        <div class="title">
            {{ qna.title }}
        </div>
        <div class="data">
        <!-- v-for 말고 다른 방법 찾기. 어차피 1개밖에 안 불러오는데 for를 할 이유가 없음. -->
            {{ qna.question }}
        </div>
        <div class="comment">
            <div class="comment_data">
                <table class="comment_table">
                    <tr v-for = "answer in answers" v-bind:key="answer">
                        <td style="color: #ff9161; font-weight: bold; vertical-align: text-top;"> {{ answer.user_id }} </td>
                        <td> {{ answer.reply }} </td>
                    </tr>
                </table>
            </div>
            <form @submit = "createAnswer">
                <input type="text" name="댓글쓰기" class="comment_text" placeholder="댓글을 남겨주세요..." style="width: 75%; display: inline-block" v-model = "view_reply" v-if="token_exist == true">
                <button v-if="token_exist == true">댓글남기기</button>
            </form>
        </div>
        <button v-on:click="goBackList" style="margin-right: 3%">목록</button>
        <button v-on:click = "updateQnA" style="margin-right: 3%" v-if="button_control == 1">수정</button>
        <button v-on:click ="deleteQnA" v-if="button_control == 1 | user.admin == 'admin'">삭제</button>
    </div>
</template>


<script>
export default {
    data() {
        return {
            qna : '',
            answers : '',
            view_reply : '',
            button_control : '',
            token_exist : $cookies.isKey('_token'),
            user : ''
        };
    },
    mounted() {
        console.log('Component mounted.')
        Axios.get('/api/qna/' + this.$route.params.id)
        .then(response => {
            this.qna = response.data.qna[0]
            this.answers = response.data.reply
            this.user = response.data.admin[0]
            if(this.qna.user_id == response.data.user)
            {
                this.button_control = 1
            }
        })
        .catch(error => {
            console.log(error)
        })
    },
    methods : {
        goBackList(){
            this.$router.push('/qna')
        },
        deleteQnA(){
            Axios.delete('/api/qna/' + this.$route.params.id)
            .then(response => {
                this.$router.push('/qna')
            })
            .catch(error => {
                console.log(error)
            })
        },
        updateQnA(){
            this.$router.push({name : "QnACreate", params : {id : this.qna.id, title : this.qna.title, question : this.qna.question}});
        },
        createAnswer(e){
            e.preventDefault();
            let currentObj = this;
            Axios.post('/api/qna',{
                control : 'reply',
                qna_id : this.$route.params.id,
                user_id : 'test',
                reply : this.view_reply
            })
            .then(response => {
                this.filter(response.data.reply)
            })
            .catch(error=>{
                console.log(error)
            })
        },
        filter(new_answers){
            this.answers = new_answers
            this.view_reply = ''
        }
    }
}
</script>


<style scoped>
.item2{
    width: 600px;
    margin-top: 13%;
    margin-left: 30%;
    color: #fff;
}

.item2 button {
    margin-top: 1%;
    margin-bottom: 1%;
    color: white;
    background-color: transparent;
    border: 0px;
    border-bottom: 2px solid white;
    font-size: 18px;
    cursor: pointer;
}

.title {
    border-bottom: 2px solid #fff;
    margin-bottom: 1%;
    text-align: center;
    font-size: 24px;
}

.data{
    border: 2px solid #fff;
    padding: 1%;
}

.comment{
    background-color: #3d3d3d;
    line-height: 1.7;
}

.comment button {
    color: white;
    background-color: transparent;
    border: 0px;
	border: 2px solid #fff;
	border-radius: 6px;
	padding: 3px;
    font-size: 15px;
    cursor: pointer;
}

.comment button:hover {
    background-color: #fff;
    color: #000;
}

.comment_table td {
    border-bottom: 1px solid #c9c9c9;
}

.comment input {
    width: 90%;
    height: 10%;
}

.comment_text{
    margin-left: 30px;
    width:600px;
    border: 1px solid #000;
}

.list_btn{
    margin-left: 225px;
    font-size: 15px;
}

.comment_data{
    margin-top: 10px;
    margin-left: 30px;
    width: 90%;
    padding: 1%;
}
</style>