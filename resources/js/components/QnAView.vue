<template>
    <div class="item2">
        <div class="title">
            {{ qna.title }}
        </div>
        <div class="data">
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
        <button v-on:click = "updateQnA" style="margin-right: 3%" v-if="button_control == 1">수정</button><!-- 자신의 글에 대해 수정 권한 가짐 -->
        <button v-on:click ="deleteQnA" v-if="button_control == 1 | user.admin == 'admin'">삭제</button> <!-- 자신의 글이거나, 관리자일 떄 삭제 권한 가짐-->
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
            token_exist : $cookies.isKey('_token'), //쿠키가 있는지 확인하는 것. 만약 있으면 true 반환
            user : ''
        };
    },
    mounted() {
        Axios.get('/api/qna/' + this.$route.params.id)  //QnAList에서 파라미터로 보낸 id를 통해 해당 QnA 정보 가져오기
        .then(response => {
            this.qna = response.data.qna[0]
            this.answers = response.data.reply
            if(response.data.admin[0]){ //로그인 되어 있는 상태면 true로 되어 작동할 것. 로그아웃이면 값이 없기 때문에 작동 안함
                this.user = response.data.admin[0] //지금 로그인 해 있는 사용자의 권한을 알기 위해서
            }
            if(this.qna.user_id == response.data.user)  //자신의 글인지 아닌지 확인하기 위해
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
        deleteQnA(){    //삭제 버튼 눌렀을 떄
            Axios.delete('/api/qna/' + this.$route.params.id)
            .then(response => {
                this.$router.push('/qna')
            })
            .catch(error => {
                console.log(error)
            })
        },
        updateQnA(){    //수정하기 눌렀을 때. 해당 QnA의 제목과 내용을 파라미터로 준다
            this.$router.push({name : "QnACreate", params : {id : this.qna.id, title : this.qna.title, question : this.qna.question}});
        },
        createAnswer(e){    //답글 생성하기
            e.preventDefault();
            let currentObj = this;
            Axios.post('/api/qna',{
                control : 'reply',
                qna_id : this.$route.params.id,
                reply : this.view_reply
            })
            .then(response => {
                this.filter(response.data.reply)    //댓글을 생성했을 때 화면 이동없이 바로 값을 바꿔주기 위해 filter라는 메서드를 연결한다
            })
            .catch(error=>{
                console.log(error)
            })
        },
        filter(new_answers){    //answers의 정보를 바꿔주고 view_reply 칸을 비워준다.
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