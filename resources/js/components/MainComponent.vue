<template>
<div class="all">
        <div class="body">
            <div class="scene one">
            </div>
            <div class="scene two">
                <header>
                    <h1>8조를 소개합니다</h1><br />
                    <h2>8조의 멤버를 소개합니다</h2>
                </header>
            </div>
            <div class="scene three">
                <header>
                    <h1>현지학기제 안내</h1><br />
                    <h2>현지학기제 주차별 설명을 소개합니다</h2>
                </header>
            </div>
            <div class="scene four">
                <header>
                    <h1>QnA</h1><br />
                    <h2>궁금한게 있으면 물어보세요!</h2>
                </header>
            </div>
        </div>
    </div>
</template>

<style scoped>
.body h1 {
    margin: 0;
    font-size: 50px;
    font-weight: bold;
    color: #ff6826;
}

.body h1::after,
.body h2::after {
    display: block;
    width: 200px;
    margin: 20px auto;
    border-bottom: 1px solid #fff;
}

header {
    color: #fff;
    max-width: 100%;
    position: relative;
    top: 50%;
    left: 50%;
    transform: translateX(-50%)translateY(-50%);
    text-align: center;
    font-weight: bold;
}

.scene {
    display: block;
    position: relative;
    width: 100%;
    height: 100vh;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
}

.scene.one {
    background-image: url('/image/univ.jpg');
}

.scene.two {
    background-image: url('/image/action.jpg');
}

.scene.three {
    background-image: url('/image/japan.jpg');
}

.scene.four {
    background-image: url('/image/que.jpg');
}

</style>