var url_api = document.currentScript.dataset.api_url;
console.log(url_api);

a = "123";

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    api_srvDetais = JSON.parse(this.responseText);

    

    if(!api_srvDetais.sucess){
    	console.log("[Api_Server_Details] Retornou false");
    	return;
    }
    if(!(api_srvDetais.server.auth && api_srvDetais.server.game)) {
    	console.log("servidor offline");
    	document.getElementsByClassName("alert-Server-Off")[0].style.display = "block";
    }

    if (!api_srvDetais.server.auth) {console.log("Auth off")}
    if (!api_srvDetais.server.game) {console.log("Game off")}


    // Chama função do feed-status na home page
    if(typeof homeFeedStatus === "function") 
        homeFeedStatus();

  }
};
xmlhttp.open("GET", url_api, true);
xmlhttp.send();
