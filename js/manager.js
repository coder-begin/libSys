$(function(){
	$("#user_manage_btn").click(function(){
		$("#userManage").show();
		$("#bookManage").hide();
	});
	$("#books_manage_btn").click(function(){
		$("#userManage").hide();
		$("#bookManage").show();
	});
	//添加学生信息功能初始化
	stuAddHandle();
    //学生搜索
	$("#stu_search").click(function(){
		if(!isAddStu()){
			var searchStu=$(this).prev("input").val();
			$.get("../php/manager.php",{"stunum":searchStu,"flag":0},function(data){
				if(data){
					var stuInfos=JSON.parse(data);
					insertStuInfos(stuInfos);
				}else{
					alert("没有此学生!!");
				}
			});
		}else{
			alert("学生已经被添加!");
		}

	});
	//更新学生信息的确定按钮
	$("#stuInfoChangeOk").click(function(){
		var stuInfosArray=[];
		$("#changeStuInfos input").each(function(){
			stuInfosArray.push($(this).val());
		});
		postUpdataStuInfos(stuInfosArray);
		$("#changeStuInfos").hide();

	});
	//更新学生信息的取消按钮
	$("#stuInfoChangeCancel").click(function(){
		$("#changeStuInfos").hide();
	});

	//更新图书信息的确定按钮
	$("#bookInfoChangeOk").click(function(){
		var bookInfosArray=[];
		$("#changeBookInfos input").each(function(){
			bookInfosArray.push($(this).val());
		});
		postUpdataBookInfos(bookInfosArray);
		$("#changeBookInfos").hide();
	});

	//更新图书信息的取消按钮
	$("#bookInfoChangeCancel").click(function(){
		$("#changeBookInfos").hide();
	});


	//添加书本功能初始化
	bookAddHandle();
    //图书搜索
    $("#book_search").click(function(){
      if(!isAddBook()){
		  var bookSearch=$(this).prev().val();
		  $.get("../php/manager.php",{"bookid":bookSearch,"flag":1},function(data){
			  if(data){
				  var bookInfos=JSON.parse(data);
				  inserBookInfos(bookInfos);
			  }else{
				  alert("没有此图书!!");
			  }
		  });
	  }else{
		  alert("图书已经被添加!!");
	  }
    });


	//判断登陆状态(session验证)
	var id=getSessionId();
	var parentChild=window.parent.document.getElementById("username");
	if(!parentChild){
		if(id){
			$.post("../php/login.php",{"id":id,"flag":1},function(data){
				if(data){
					window.location.href="../main.html";
				}else{
					window.location.href="../index.html";
				}
			});
		}
	}
});
//判断学生是否已经被添加
function isAddStu(){
	var flag=false;
	$("#addStuInfos>tr>td:first-child").each(function(index){
		var inputText= $("#stu_search").prev().val();
		if($(this).text()==inputText){
			flag=true;
		}
	});
	return flag;
}
//post更新的学生信息
function postUpdataStuInfos(stuInfos){
	$.post("../php/manager.php",{"stuinfos":stuInfos,"flag":2},function(data){
				if(data){
					updateStuList(stuInfos);
					alert("更新成功!");
				}else{
					alert("更新失败!");
				}
	});
}
//更新学生列表
function updateStuList(stu){
	$("#addStuInfos>tr>td:first-child").each(function(){
		if($(this).text()==stu[2]){
			$(this).next().text(stu[0]).next().text(stu[3]);
		}
	})
}
//获取和添加学生
function stuAddHandle(){
	$("#addStu").click(function(){
		$("#stusPrompt").show();
	});
	$("#submitStuInfos").click(function(){
		$("#stusPrompt").hide();
        var stuName=$("#stuName").val();
        var stuNum=$("#stuNum").val();
        var stuMajor=$("#stuMajor").val();
        $.post("../php/manager.php",{"flag":0,"stunum":stuNum,"stuname":stuName,"stumajor":stuMajor},function(data){
            if(data==true){
                alert("添加成功");
            }else{
                alert("添加失败");
            }
        });


	});

	$("#stuCancel").click(function(){
		$("#stusPrompt").hide();
	});
}

//获取sessionid
function getSessionId() {
	var cookie = document.cookie.toString();
	var sessionIdStart = cookie.indexOf("PHPSESSID"),
		sessionIdEnd = cookie.indexOf(";", sessionIdStart),
		sessionId;
	if (sessionIdStart == -1) {
		window.location.href = "../index.html";
	} else {
		if (sessionIdEnd == -1) {
			sessionId = cookie.substr(sessionIdStart);
		}
		else {
			sessionId = cookie.substr(sessionIdStart, sessionIdEnd);
		}
		var id = parseInt(sessionId.split("=")[1]);
		return id;
	}
}
//向table中插入搜索到的学生信息
var stuInfos;
function insertStuInfos(stuinfos){
	stuInfos=stuinfos;
	var onestuinfo= "<tr>"+
						"<td>"+stuinfos.stunum+"</td>"+
						"<td>"+stuinfos.username+"</td>"+
						"<td>"+stuinfos.major+"</td>"+
						"<td><button onclick='deleteStuInfos($(this))'>删除</button><button onclick='updataStuInfos()'>更新</button></td>"+
					"</tr>";
	$("#addStuInfos").append(onestuinfo);
}
function fromObjectToArr(obj){
	var Arr=[];
	for(var index in obj){
		Arr.push(obj[index]);
	}
	return Arr;
}
//删除学生数据
function deleteStuInfos($this){
	$.post("../php/manager.php",{"flag":3,"stunum":$this.parent().prev().prev().prev().text()},function(data){
					if(data){
						$this.parent().parent()[0].outerHTML=null;
						alert("删除成功!!");
					}else{
						alert("删除失败!!");
					}
	})
}
//更新学生数据
function updataStuInfos(){
	var stus=fromObjectToArr(stuInfos);
	$("#changeStuInfos input").each(function(index){
		$(this).val(stus[index]);
	});
	$("#changeStuInfos").show();

}

//------------------------------------------------------------------------------------
//向table中添加搜索到的图书信息
var  bookInfos;
function inserBookInfos(bookinfos){
	bookInfos=bookinfos;
	var onebookinfo= "<tr>"+
		"<td>"+bookinfos.bookid+"</td>"+
		"<td>"+bookinfos.bookname+"</td>"+
		"<td>"+bookinfos.author+"</td>"+
		"<td><button onclick='deleteBookInfos($(this))'>删除</button><button onclick='updateBookInfos()'>更新</button></td>"+
		"</tr>";
	$("#addBookInfos").append(onebookinfo);
}
//更新图书信息
function updateBookInfos(){
	var book=fromObjectToArr(bookInfos);
	$("#changeBookInfos input").each(function(index){
		$(this).val(book[index]);
	});
	$("#changeBookInfos").show();

}
//post更新的图书信息
function postUpdataBookInfos(bookinfos){
	$.post("../php/manager.php",{"bookinfos":bookinfos,"flag":4},function(data){
		if(data){
			updateBookList(bookinfos);
			alert("更新成功!");
		}else{
			alert("更新失败!");
		}
	});
}
//更新图书列表
function updateBookList(bookinfos){
	$("#addBookInfos>tr>td:first-child").each(function(){
		if($(this).text()==bookinfos[0]){
			$(this).next().text(bookinfos[1]).next().text(bookinfos[2]);
		}
	})
}
//删除图书信息
function deleteBookInfos($this){
	$.post("../php/manager.php",{"flag":5,"bookid":$this.parent().prev().prev().prev().prev().text()},function(data){
		if(data){
			$this.parent().parent()[0].outerHTML=null;
			alert("删除成功!!");
		}else{
			alert("删除失败!!");
		}
	})


}
//判断图书是否被添加
function isAddBook(){
	var flag=false;
	$("#addBookInfos>tr>td:first-child").each(function(index){
		var inputText= $("#book_search").prev().val();
		if($(this).text()==inputText){
			flag=true;
		}
	});
	return flag;
}
//添加图书信息
function bookAddHandle(){
	$("#addBook").click(function(){
		$("#bookPrompt").show();
	});
	$("#submitBookInfos").click(function(){
		$("#bookPrompt").hide();
		var bookid=$("#bookId").val();
		var bookname=$("#bookName").val();
		var bookauthor=$("#bookAuthor").val();
		$.post("../php/manager.php",{"bookid":bookid,"bookname":bookname,"bookauthor":bookauthor,"flag":1},function(data){
			if(data==true){
				alert("添加成功!!");
			}else{
				alert("添加失败!!");
			}
		});
	});

	$("#bookCancel").click(function(){
		$("#bookPrompt").hide();
	});
}
