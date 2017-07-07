$(function(){
    initEvent();
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
//获取sessionid
function getSessionId(){
    var cookie=document.cookie.toString();
    var sessionIdStart = cookie.indexOf("PHPSESSID"),
        sessionIdEnd = cookie.indexOf(";", sessionIdStart),
        sessionId;
    if(sessionIdStart==-1){
        window.location.href="../index.html";
    }else{
        if(sessionIdEnd==-1){
            sessionId=cookie.substr(sessionIdStart);
        }
        else{
            sessionId=cookie.substr(sessionIdStart,sessionIdEnd);
        }
        var id=parseInt(sessionId.split("=")[1]);
        return id;
    }
}
function getUserInfos(){
        var id=getSessionId();
        if(id){
            $.get("../php/reader.php", {id: id,flag:0},function(data){
                if(data){
                    var gettedData=JSON.parse(data);
                    initInterface(gettedData);
                }else{
                    window.location.href="index.html";
                }
            });
            $.get("../php/reader.php", {id: id,flag:3},function(data){
                if(data){
                    var gettedData=JSON.parse(data);
                    initBorrowedList(gettedData);

                }else{
                    window.location.href="index.html";
                }
            });
        }else{
            window.location.href="index.html";
        }
}
//初始化借书列表
/*


 */
function initBorrowedList(infos){
    $("#borrowed_list").empty();
    for(var index in infos){
        var onebookinfo=infos[index].split("_");
        var onebookinfos="<tr>"+
                             "<td>"+onebookinfo[0]+"</td>"+
                             "<td>"+onebookinfo[1]+"</td>"+
                             "<td>"+onebookinfo[2]+"</td>"+
                             "<td>"+onebookinfo[3]+"</td>"+
                             "<td>"+onebookinfo[4]+"</td>"+
                        "</tr>";

        $("#borrowed_list").append(onebookinfos);
    }
}



//初始化用户信息
function initInterface(infos){
    var notreturnednum=0;
    var allInfos=$("#allUserInfos span");
    $(allInfos[0]).text(infos.username);
    $(allInfos[1]).text(infos.carddata);
    $(allInfos[2]).text(infos.owe);
    $(allInfos[3]).text(infos.stunum);
    $(allInfos[4]).text(infos.maxbringnum);
    if(infos.notreturned==null){
        $(allInfos[5]).text(notreturnednum);
    }else{
        notreturnednum=infos.notreturned.split(";").length;
        $(allInfos[5]).text(notreturnednum);
    }
    $(allInfos[6]).text(infos.major);
    var hadbroughtnum=infos.hadbroughtbooks.split(";").length;
    $(allInfos[7]).text(hadbroughtnum+notreturnednum);
    setInterval(function(){
        var currentTime=new Date();
        $(allInfos[8]).text(currentTime.getHours()+":"+currentTime.getMinutes()+":"+currentTime.getSeconds());
    },1000);
}


function initEvent(){
    $("#my_library").click(function(){
        $(".firstPage").show();
        $(".user_manage").hide();
        $(".borrowing_ranking").hide();
        $(".bring_manage").hide();
        $(".take_back_manage").hide();

    });
    $("#userInfo_btn").click(function(){
        $(".user_manage").show();
        $(".firstPage").hide();
        $(".borrowing_ranking").hide();
        $(".bring_manage").hide();
        $(".take_back_manage").hide();
        getUserInfos();

    });
    $("#borrowing_ranking").click(function(){
        $(".borrowing_ranking").show();
        $(".user_manage").hide();
        $(".firstPage").hide();
        $(".bring_manage").hide();
        $(".take_back_manage").hide();
        insertRankingBook();


    });
    //bring_manage
    $("#bring_manage").click(function(){
        $(".bring_manage").show();
        $(".borrowing_ranking").hide();
        $(".user_manage").hide();
        $(".firstPage").hide();
        $(".take_back_manage").hide();
        setBringBookDate();
        setBookDeadline();
    });

    $("#take_back_manage").click(function(){
        //take_back_manage
        $(".take_back_manage").show();
        $(".bring_manage").hide();
        $(".borrowing_ranking").hide();
        $(".user_manage").hide();
        $(".firstPage").hide();
        setTakeBookBackDate()
    });
    //初始化"我的图书馆"界面搜索按钮
    $("#book_search").click(function(){
      var searchbookname = $(this).prev().val();
        $.get("../php/reader.php", {bookname: searchbookname,flag:1},function(data){
            if(data){
                var bookInfos=JSON.parse(data);
                addBookInfos(bookInfos);
            }else{
                alert("没有这本书");
            }
        });


    });

    //初始化借书管理界面的确定按钮
    $("#submit").click(function(){
        $.post("../php/reader.php",{"bookid":$("#bookid").val(),"id":getSessionId(),"flag":0},function(data){
            if(data){
                $("#showBorrowMessage").text("借书完成");
            }else{
                $("#showBorrowMessage").text("借书失败");
            }
        });
    });
    //初始化还书管理界面的确定按钮
    $("#returnBookSubmit").click(function(){
        $.post("../php/reader.php",{"bookid":$("#bookid").val(),"id":getSessionId(),"flag":1},function(data){
            if(data){
                $("#bring_date").text("还书完成!!!");
            }else{
                $("#bring_date").text("还书失败!!!");
            }
        });
    })


}
//向table中添加图书信息
function addBookInfos(infos){
   var onebookinfos="<tr><td>"+infos.bookid+"</td><td>"+infos.bookname+
       "</td><td>"+infos.author+"</td><td>"+infos.publish_house+"</td></tr>";
    $("#allBooks").append(onebookinfos);


}
//添加图书排行
function insertRankingBook(){
    function dealAllbooks(books){
        $("#show_ranking_books").empty();
        for(var index in books){
            var onebookInfos="<tr>"+
                                "<td>"+books[index].bookid+"</td>"+
                                "<td>"+books[index].bookname+"</td>"+
                                "<td>"+books[index].publish_house+"</td>"+
                                "<td>"+books[index].author+"</td>"+
                                "<td>"+books[index].beingborrowednum+"</td>"+
                                "</tr>";
            $("#show_ranking_books").append(onebookInfos);
        }

    }
    $.get("../php/reader.php",{flag:2},function(data){
        if(data){
            var allBookInfos=JSON.parse(data);
            dealAllbooks(allBookInfos);
        }else{
            alert("没有这本书");
        }
    });


}

function setTakeBookBackDate(){
    var date=new Date();
    var year=date.getFullYear();
    var month=date.getMonth()+1;
    var day=date.getDate();
    $("#take_back_date").text(year+"/"+month+"/"+day);
}
function setBookDeadline(){
    var date=new Date();
    var year=date.getFullYear();
    var month=date.getMonth()+2;
    var day=date.getDate();
    $("#book_deadline").text(year+"/"+month+"/"+day);
}
function setBringBookDate(){
    var date=new Date();
    var year=date.getFullYear();
    var month=date.getMonth()+1;
    var day=date.getDate();
    $("#bring_book_date").text(year+"/"+month+"/"+day);
}

