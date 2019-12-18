<template>
    <div class="all">
        <form @submit = "postJapan">
            <div class="jpn_contents">
                <p>새로운 내용 입력하기</p>
                <input type="text" class="form_control" placeholder="제목" style="color: #fff; font-size: 24px" maxlength="100" v-model = "title">
                <br/>
                <textarea class="form_control2" placeholder="내용"  maxlength="2048"    style="height: 400px; color: #fff" v-model="info"/>
            
                <div class="img_upload">
                    <div>
                        <div class="img_wrap">
                            <img id="img" :src="image" />
                        </div>
                    </div>
                    <div>
                        <input type="file" id="input_img" accept="image/*"/>
                    </div>
                </div>
            </div>
            <button id = "ok_modify">완료</button>
        </form>
    </div>
</template>
<script>
import { type } from 'os';
export default {
    data :{
        info : '',
        week: '',
        image: '',
        title: '',
    },
    mounted() {
        this.week = this.$route.params.week
        /* 사진 업로드 시 미리보기 */
        var vm = this
        $(document).ready(function() {
            $("#input_img").on("change", handleImgFileSelect);
        });

        function handleImgFileSelect(e) {
            vm.image = e.target.files[0];

            var reader = new FileReader();
            reader.readAsDataURL(vm.image); //이미지 파일 읽어서 e.target.result에 넘겨줌
            reader.onload = function(e) {
                $("#img").attr("src", e.target.result);
            }
        }
    },
    methods:{
        postJapan(e){
            e.preventDefault();
            let currentObj = this;
            let config = {
                headers: {
                    processData: true, 
                    contentType: "multipart/form-data", // image 전송할 때는 타입을 지정해줘야함
                }
            }
            const form = new FormData()
            const week = this.$route.params.week
            const info = this.info
            const image = this.image
            const title = this.title

            form.append('week', week)
            form.append('info', info)
            form.append('image', image)
            form.append('title', title)
           
            Axios.post('/api/japan', form, config)
            .then(response=>{
                this.$router.go(-1)
            })
            .catch(error=>{
                console.log(error)
            })
        },
    }
}
</script>

<style scoped>

    .jpn_contents {
        margin-top: 13%;
        text-align: center;
    }

    .form_control{
        margin-top: 20px;
        margin: 0 auto;
        padding-bottom: 1%;
        width:600px;
        border: 0px solid transparent;
        border-bottom: 2px solid #fff;
        background-color: transparent;
    }

    .form_control2{
        width:600px;
        border: 2px solid #fff;
        background-color: transparent;
        margin-top: 1%;
    }
    
    .jpn_contents p {
        text-align: center; 
        color: #fff; 
        font-size: 20px;
    }

    .img_upload {
        color: #fff;
        text-align: center;
        margin-top: 2%;
    }

    .img_upload input {
        margin-left: 5%;
    }

    #ok_modify {
        color: white;
        background-color: transparent;
        border: 0px;
        border-bottom: 2px solid white;
        font-size: 18px;
        margin-right: 50px;
        cursor: pointer;
        margin-left: 50%;
        margin-top: 2%;
        margin-bottom: 3%;
    }

    .img_wrap img{
        max-width : 80%;
    }
</style>