<template>
    <div class="all">
        <div class="body">
            <section class="MOD_ACCORDION1">
                <div data-layout="_r">
                    <div data-layout="al16">
                        <div class="AP_accordion" role="tablist"><!-- 로그인 세션 아이디 점검 -->
                            <p class="AP_accordion_tab" role="tab" data-theme="_bgp1" tabindex="0">수정하기</p>
                            <div class="AP_accordion_panel" role="tabpanel"> <!-- 화면 상에 보여지는 탭 -->
                                <img src="/image/bird.jpg" class="mem1"> <!-- 탭 클릭했을 때 보이는 조원1의 배경사진 -->
                                <div id="member_member1Hidden"> <!-- 탭을 클릭 했을 때 보이는 조원1의 사진, 이름, 한줄소개 -->
                                    <img v-if="check == 1" :src="'/images/'+member.imagename" id="member_member1Image" width="100" height="100"><br />
                                    <img v-if="check == 0" :src="uploadImageFile" id="member_member1Image" width="100" height="100"><br />
                                    이름 : <p>{{ user_name }}</p>
                                    소개 : <input type="text" v-model="member_info" :placeholder="member.member_info"> <br />
                                    이미지 : <input type="file" accept="image/*" v-on:change="onImageChange" :id="member.id"> <br />
                                    <input type="button" value="수정하기" @click="update" class = "ok-button">
                                    <input type="button" value="뒤로가기" @click="back" class = "cancel-button">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            member : { user :{ name : '로딩중' }, imagename : '로딩중', member_info : '로딩중' }, // 시간차 렌더
            member_info : '',
            image :'',
            user_name : this.$route.params.user_name,
            uploadImageFile : '',
            check : 1,
            click : true
        }
    },
    mounted() {
        const user_name = this.user_name;
        Axios.get(`/api/member/${user_name}`)
        .then(res => 
        {
            this.member=res.data.member
        })
        .catch(err=> {
            console.log(err)
        });   
    },
    methods: {
        back() {
            this.$router.push('/member')
        },
        update(e) {
            if (this.click){
                this.click = false
                
                let config = {
                    headers: {
                        processData: true, 
                        contentType: "multipart/form-data", 
                    }
                } 
                const form = new FormData()
                const user_name = this.user_name
                const member_info = this.member_info
                const image = this.image
                form.append('_method', 'patch') //form태그에서는 put이랑 get밖에 지원을 안해서 patch를 사용하기 위해서 사용했다.
                form.append('user_name', user_name)
                if(member_info) {
                    form.append('member_info', member_info)
                } else {
                    form.append('member_info', '없음')
                }
                if(image) {
                    form.append('image',image)
                } else {
                    form.append('image', '없음')
                }
                Axios.post(`/api/member/${user_name}`, form, config)
                .then(res => {
                    this.$router.push('/member')
                })
                .catch(err => {
                    console.log(err)
                });
            }
        },
        onImageChange(e){ // 이미지 파일 찾아내기
            this.image = e.target.files[0]
            var input = e.target.files[0];
            this.check = 0
            if(!input.type.match("image.*")) {
                alert("확장자는 이미지 확장자만 가능합니다.");
                return;
            }
            var reader = new FileReader();
            reader.readAsDataURL(input);
            reader.onload = (e) => {
                this.uploadImageFile = e.target.result;
            }
        }
    }
}
</script>

<style scoped>
.body {margin-top: 13%;margin-left: 8%;height: auto}
.mem1,
.mem2,
.mem3,
.mem4,
.mem5,
.mem6 {
    width: 100%;
}

.intro {
    background-color: transparent;
    border: 0px solid transparent;
    border-bottom: 2px solid white;
    color: #fff;
}

#member_member1Image,
#member_member2Image,
#member_member3Image,
#member_member4Image,
#member_member5Image,
#member_member6Image {width: 20%;float: inherit}
#member_member1Hidden {
    background-color: rgba(0, 0, 0, 0.7);
    text-align: center;
    color: white;
    font-size: 20px;
    position: relative;
    z-index: 100;
    margin-top: -73%;
    padding-top: 20%;
    padding-bottom: 20%;
}

#member_member1Hidden .ok-button, .cancel-button {
    color: white;
    background-color: transparent;
    border: 0px;
   border: 2px solid #fff;
   border-radius: 6px;
    margin-top: 3%;
   padding: 3px;
    font-size: 15px;
    cursor: pointer;
}

.ok-button:hover {
    background-color: #fff;
    color: #000;
}

.cancel-button:hover {
    background-color: #fff;
    color: #000;
}

[data-theme*=_bgp1] {
    /* background: url(/image/bird.jpg); */
    background: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 1) 70%), url(/image/bird.jpg);
    background-repeat: no-repeat;
    /* background-image: linear-gradient(to right, rgba(255,0,0,0), rgba(255,0,0,1)); */
    color: white;
}
[data-theme*=_bgp2] {
    /* background: url(/image/cat.jpg); */
    background: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 1) 70%), url(/image/cat.jpg);
    background-repeat: no-repeat;
    color: white;
}
[data-theme*=_bgp3] {
    /* background: url(/image/tiger.jpg); */
    background: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(0, 0, 0, 1) 70%), url(/image/tiger.jpg);
    background-repeat: no-repeat;
    color: white;
}
[data-theme*=_bgp4] {
    /* background: url(/image/hed.jpg); */
    background: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(0, 0, 0, 1) 70%), url(/image/hed.jpg);
    background-repeat: no-repeat;
    color: white;
}
[data-theme*=_bgp5] {
    /* background: url(/image/lion.jpg); */
    background: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(0, 0, 0, 1) 70%), url(/image/lion.jpg);
    background-repeat: no-repeat;
    color: white;
}
[data-theme*=_bgp6] {
    /* background: url(/image/dog.jpg); */
    background: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(0, 0, 0, 1) 70%), url(/image/dog.jpg);
    background-repeat: no-repeat;
    color: white;
}
[data-layout=_r] {
    max-width: 100%;
    margin-left: 3%;
    /*margin: 0 auto;*/
    /*    padding: 2rem 1rem;*/
}
[data-layout=_r] > div,
[data-layout=_r] > article,
[data-layout=_r] > aside {
    padding: 0 1rem 1rem 1rem;
}
[data-layout=_r] img {
    height: auto;
}
a.btn,
button {
    background-color: #4d36bd;
    color: white;
    text-decoration: none;
    display: inline-block;
    padding: 1em;
    border-radius: 5px;
    border: none;
    font-family: sans-serif;
    font-size: 1em;
    cursor: pointer;
}
a.btn:hover,
button:hover {
    filter: brightness(1.1);
}
/*Accordion Generic*/
 /*탭 배경사진*/
.AP_accordion_panel {
    overflow: hidden;
    transition: height 0.3s;
    position: relative;
    width: 88%;
}
.AP_accordion_tab {
    width: 88%;
    height: 60px;
    cursor: pointer;
    margin: 0;
    line-height: 1;
    padding-top: 25px;
    font-weight: bold;
    position: relative;
    font-size: 2.8em;
    color: rgba(255, 255, 255, 0.5);
    font-style: oblique; /* italic */
    letter-spacing: -3px;
}
.AP_accordion_tab.open {
    filter: brightness(1.05);
}
.AP_accordion_tab.open:after {
    transform: rotateZ(180deg);
}
.AP_accordion_tab:hover {
    filter: brightness(1.1);
}
.AP_accordion_tab:after {
    position: absolute;
    font-size: 1.4em;
    right: 0;
    /* line-height: 1; */
    top: 0;
    height: 100%;
    width: 88%;
    display: flex;
    align-items: center;
    justify-content: center;
}
/* Accordion1 */
.MOD_ACCORDION1 .AP_accordion {
    margin: 0;
    max-width: 100%;
}
.MOD_ACCORDION1_Intro {
    max-width: 100%;
    margin-bottom: 2rem;
}
</style>