<template>
    <div class="all">
        <div class="body">
            <section class="MOD_ACCORDION1">
                <div data-layout="_r">
                    <div data-layout="al16">
                        <div class="AP_accordion" role="tablist">
                            <div v-for="member in members" :key="member.id"> <!-- 반복문 v-for 조원 생성 -->
                            <p class="AP_accordion_tab" role="tab" :data-theme="'_bgp'+member.user_id" tabindex="0"> {{ members.indexOf(member) + 1 }}. {{ member.user.name }}</p>
                            <div class="AP_accordion_panel" role="tabpanel"> <!-- 화면 상에 보여지는 탭 -->
                                <img :src="'/image/'+image[member.user_id-1]" class="mem1"> <!-- 탭 클릭했을 때 보이는 조원1의 배경사진 -->
                                <div id="member_member1Hidden"> <!-- 탭을 클릭 했을 때 보이는 조원1의 사진, 이름, 한줄소개 -->
                                    <img :src="'images/'+member.imagename" id="member_member1Image" alt="조원사진" width="100" height="100"><br />
                                    <p id="member_member1Name" style="margin-top: 1%">이름 : {{ member.user.name }}</p>
                                    <p id="member_member1Intro" style="margin-top: 1%">소개 : {{ member.member_info }}</p>
                                    <div> <!-- lv이 2인 관리자만 보이게 만들기 session 필요 또한 자기것만 보이게 -->
                                    <input v-if="member.user_id == check" @click="update" type="button" value="수정하기" :id="user_name">
                                    <input v-if="member.user_id == check" @click="destroy" type="button" value="삭제하기" :id="user_name">
                                    </div>
                                </div>
                            </div>
                            </div>
                            <!-- lv이 2인 관리자만 보이게 만들기 session 필요 -->
                            <p v-if="check==0 && admin == 'admin'" @click="create" class="AP_accordion_tab" role="tab" data-theme="_bgp2" tabindex="0" :id="user_name">생성하기</p> <!-- 로그인 유저 아이디 -->
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
            members:{},
            lv: 2,
            user_name : '',
            admin : '',
            check : '',
            image : []
        }
    },
    mounted() {
        this.image = ['bird.jpg', 'cat.jpg', 'tiger.jpg', 'hed.jpg', 'lion.jpg', 'dog.jpg']
        Axios.get("/api/member")
        .then(res => 
        {
            // console.log(res);
            this.members=res.data.member
            this.user_name=res.data.user_name[0].name
            this.admin=res.data.admin[0].admin
            if(res.data.check[0]) {
                this.check=res.data.check[0].user_id
            }
            else {
                this.check=0
            }
        })
        .catch(err=> {
            console.log(err)
        });    
    },
    methods: {
        create(e) {
            const id = e.target.id
            this.$router.push({name: 'MemberCreate', params: {"user_name" : id}}) // 로그인 아이디 필요
        },
        update(e) {
            const id = e.target.id
            this.$router.push({name: 'MemberUpdate', params: {"user_name" : id}})
        },
        destroy(e) {
            const id = e.target.id
            axios.delete(`/api/member/${id}`)
                .then(res =>
                {
                    this.members=res.data.member
                    this.check=0
                    this.admin='admin'
                })
                .catch(err => {
                console.log(err)
            })
        }
    }
}
</script>

<style scoped>
.body {margin-top: 13%;margin-left: 8%;height: auto}
.mem1 {
    width: 100%;
}
#member_member1Image {width: 20%;float: inherit}
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

#member_member1Hidden input {
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

#member_member1Hidden input:hover {
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