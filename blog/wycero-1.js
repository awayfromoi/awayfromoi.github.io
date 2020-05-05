function ispc() {
  var userAgentInfo = navigator.userAgent;
  var Agents = ["Android", "iPhone",
        "SymbianOS", "Windows Phone", "iPod"];
  var flag = true;
  for (var v = 0; v < Agents.length; v++) {
    if (userAgentInfo.indexOf(Agents[v]) > 0) {
      flag = false;
      break;
    }
  }
  return flag;
}
$(".posti-group>.posti").removeClass("alone");
tabcon=document.getElementById("table-content");
if(!ispc()){
if(tabcon)tabcon.style.width=tabcon.style.maxWidth="70%";
}
if(tabcon)tabcon.style.right="-70%";
function open_content(){
    if(tabcon)tabcon.style.right="0%";
}
function close_content(){
    if(tabcon)tabcon.style.right="-70%";
}
function off_content(){
    if(tabcon)tabcon.style.opacity="0";
}
function close_front(){
    $(".frontpage").css("opacity","0");
    setTimeout(()=>{$(".frontpage").css("display","none");},500)
}
$("ul>li:has(a:only-child)").addClass("link-li");
$("ul").each((ind,elem)=>{
    var cnt1=0;
    var cnt2=0;
    $(elem).children().each(()=>{cnt1++;})
    $(elem).children(".link-li").each(()=>{cnt2++;})
    if(cnt1==cnt2){
        $(elem).addClass("posti-group");
        $(elem).children().addClass("posti");
    }
})
