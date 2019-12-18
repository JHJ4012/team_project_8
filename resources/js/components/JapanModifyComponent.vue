<template>
    <div class="all">
        <form @submit="updateJapan">
            <div class="jpn_contents">
                <p>내용 수정하기</p>
                <input type="text" class="form_control" placeholder="제목" style="color: #fff; font-size: 24px" maxlength="100" v-model = "title">
                <br/>
                <textarea class="form_control2" placeholder='내용' maxlength="2048"    style="height: 400px; color: #fff" v-model="info"/>
            </div>
            <div class="img_upload">
                <div>
                    <div class="img_wrap">
                        <img id="img" />
                    </div>
                </div>
                <div>
                    <input type="file" id="input_img" accept="image/*" @change="uploadImage($event)"/>
                </div>
            </div>
            <button id = "ok_modify">수정</button>
        </form>
    </div>
</template>
<script>
export default {
    data(){
        return {
            info: '',
            newImage : '',
            title : '',
            week : '',
        }
    },
    mounted() {
        Axios.get('/api/japan/modify/' + this.$route.params.id)
        .then((response) => {
            this.info = response.data.japans[0].info
            this.newImage = response.data.japans[0].image
            this.title = response.data.japans[0].title
            this.week = response.data.japans[0].week
        })
        .catch(error => {
            console.log(error)
        })

        /* 사진 업로드 시 미리보기 */
        var sel_file;
        var vm = this
        $(document).ready(function() {
            $("#input_img").on("change", handleImgFileSelect);
        });

        function handleImgFileSelect(e) {
            vm.newImage = e.target.files[0];

            var reader = new FileReader();
            reader.readAsDataURL(vm.newImage); //이미지 파일 읽어서 e.target.result에 넘겨줌
            reader.onload = function(e) {
                $("#img").attr("src", e.target.result);
            }
        }
    },


    methods : {
        updateJapan(e){
            e.preventDefault();

            let config = {
                headers: {
                    processData: true, 
                    contentType: "multipart/form-data", 
                }
            }
            let currentObj = this;
            const form = new FormData()
            const week = this.week
            const info = this.info
            const image = this.newImage
            const title = this.title

            form.append('_method', 'patch')
            form.append('week', week)
            form.append('info', info)
            form.append('image', image)
            form.append('title', title)

            Axios.post('/api/japan/'+ this.$route.params.id, form, config)
            .then(response=>{
                this.$router.go(-1)
            })
            .catch(error=>{
                console.log(error)
            })
        }
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
</style>