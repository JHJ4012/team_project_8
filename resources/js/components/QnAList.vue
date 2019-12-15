<template id = "qna-lists">
	 <div class="qna_list">
		<table class="table" border="2">
			<colgroup>
				<col width="50" />
				<col width="500" />
				<col width="100" />
				<col width="100" />
				<col width="90" />
			</colgroup>
			<thead>
				<tr>
					<th>번 호</th>
					<th>제 목</th>
					<th>글쓴이</th>
					<th>날짜</th>
					<th>조회수</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for = "qna in qnas.data" v-bind:key="qna" @click="clickQnA(qna)"><!-- v-for문을 통해 list 수만큼 만듬 --> 
					<td>{{ number + (qnas.data.indexOf(qna)+1 )}}</td>
					<td>{{ qna.title }}</td>
					<td>{{ qna.user_id }}</td>
					<td>{{ qna.created_at }}</td>
					<td>{{ qna.view }}</td>
				</tr>
			</tbody>
		</table>
		<pagination :data="qnas" @pagination-change-page="getResults" class="pagination"><!-- 페이징 --> 
			<button slot="prev-nav">&lt; 이전</button>
			<button slot="next-nav">다음 &gt;</button>
		</pagination>
		<router-link to="/qna/create" v-if="token_exist == true"><!-- cookie가 있으면 글쓰기 버튼을 나타나게 하기 --> 
			<button id = "new">글쓰기</button>
		</router-link>
    </div>
</template>
<script>
export default {
	data:function(){
		return {
			qnas: {},
			page : 0,
			token_exist : $cookies.isKey('_token')
		};
	},
	mounted : function(){
		this.getResults();
	},
	methods: {
		clickQnA(qnaObj){ //각 qna를 클릭했을 때
			console.log(qnaObj.id)
			this.$router.push({name : "QnAView", params : {id : qnaObj.id}});
		},
		getResults(page=1){  //페이징 기능
			axios.get('/api/qna?page=' + page)
			.then(response => {
				this.page = page
				this.qnas = response.data;
			});
		}
	},
	computed : {   //QnA 리스트 표시할 때 앞에 QnA 번호 순서대로 나타나게 하기 위해서
                  //computed는 연산을 위한 것.
		number : function(){
			return ((this.page-1) * 5)
		}
	}
}

</script>

<style>
   .pagination {
      list-style: none;
      display: inline-block;
      margin-top: 3%;
      width: 100%;
   }
   .pagination li {
      display: inline;
   }
   .pagination li.previous {
      visibility: collapse;
   }
   .pagination a{
      color: #fff;
      text-decoration: none;
   }
   .sr-only {
      display: none;
   }
   .pagination button {
      color: white;
      background-color: transparent;
      border: 2px solid #fff;
      border-radius: 6px;
      padding: 3px;
      font-size: 15px;
      cursor: pointer;
   }
   .pagination button:hover {
      background-color: #fff;
      color: #000;
   }
   .pagination-page-nav {
      padding: 10px;
   }
   .pagination-page-nav {
      border: 1px solid #fff;
      border-radius: 50%;
   }
   .pagination-page-nav:hover {
      background-color: #ff9d73;
      border-radius: 50%;
   }
   .page-item.active{
      background-color: #ff5b14;
      border-radius: 50%;
   }
</style>


<style scoped>
.qna_list {
   margin-top: 13%;
   margin-left: 20%;
   margin-right: 20%;
}

.table{
    width: 100%;
   height: 100px;
   background-color: transparent;
   color: #fff;
   border-collapse: collapse;
   border-top: 3px solid #3d3d3d;
   border-left: 0px transparent;
   border-right: 0px transparent;
}

.table tbody {
   cursor: pointer;
   text-align: center;
}

.table th {
   color: #3d3d3d;
   background: #b8b8b8;
   text-align: center;
}

.table th, .table td {
   padding: 3px;
   border: 1px solid #ddd;
}

.table th:first-child, .table td:first-child {
   border-left: 0;
}

.table th:last-child, .table td:last-child {
   border-right: 0;
}

.table tr td:first-child {
   text-align: center;
   padding-top: 1%;
   padding-bottom: 1%;
}

.table caption {caption-side: bottom; display: none;}

#new {
   cursor: pointer;
    color: white;
    background-color: transparent;
    border: 0px;
   border-bottom: 2px solid white;
   float: right;
   font-size: 15px;
   margin-top: 1%;
}

.table caption {caption-side: bottom; display: none;}

</style>