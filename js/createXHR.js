/**
 * Created by rulersex on 2017/5/3.
 */
function createXHR(){
    var request;
    if(window.XMLHttpRequest) {
        if (typeof XMLHttpRequest != "undefined") {
            try{
                request = new XMLHttpRequest();

            }catch (e){
                  request=false;
            }
        }
    }else if(window.ActiveXObject){
        try{
            request=new ActiveXObject("Msxml2.XMLHTTP");
        }catch (e){
            try{
                request=new ActiveXObject("Microsoft.XMLHTTP")
            }catch(e){
                request=false;
            }
        }
    }
}
