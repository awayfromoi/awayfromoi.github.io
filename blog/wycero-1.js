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
tabcon=document.getElementById("table-content");
if(!ispc()){
tabcon.style.width=tabcon.style.maxWidth="70%";
}
tabcon.style.left="-70%";
function open_content(){
    tabcon.style.left="0";
}
function close_content(){
    tabcon.style.left="-70%";
}
function off_content(){
    tabcon.style.opacity="0";
}
