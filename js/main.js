$(function(){
    getLoginInfos();

});
function initInterface(data){
    $("#userKind")[0].src=data.src;
    $("#stuNum").text(data.stunum);
    $("#username").text(data.username);
}
function getLoginInfos(){
   var cookie=document.cookie.toString();
    var sessionIdStart = cookie.indexOf("PHPSESSID"),
        sessionIdEnd = cookie.indexOf(";", sessionIdStart),
        sessionId;
    if(sessionIdStart==-1){
        window.location.href="index.html";
    }else{
        if(sessionIdEnd==-1){
            sessionId=cookie.substr(sessionIdStart);
        }
        else{
            sessionId=cookie.substr(sessionIdStart,sessionIdEnd);
        }
        var id=sessionId.split("=")[1];
       if(id){
           $.get("php/login.php", {id: id},function(data){
               if(data){
                   var gettedData=JSON.parse(data);
                   initInterface(gettedData);

               }else{
                   window.location.href="index.html";
               }
           });
       }else{
           window.location.href="index.html";
       }

    }





}