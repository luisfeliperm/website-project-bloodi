function edita_texto(elemento_id, texto){
	document.getElementById(elemento_id).innerHTML = texto;
}
function display_edit(elemento_id, display){
	var idd = document.getElementById(elemento_id);
	idd.style.display = display;
}
function limiteCaract(string = "", total){
	string.value = string.value.substring(0,total);
}
function IsEmail(email){
    var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	if(!filter.test(email)){
		return false;
	}
}
function is_url(str) {
	var regexp = /(data|ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
  	//Retorna boolean
    return regexp.test(str);
}
function ant_xfs(id,nivel = 1){
	if (nivel == 1) {
		str = id.value.replace(/'/g, '');
	}else{
		str = id.value.replace(/<|>|'|#|\*|"/g, '');
	}
	
	id.value = str;
}
				
function removeAcento(text){
    text = text.replace(new RegExp('[ÁÀÂÃ]','gi'), 'a');
    text = text.replace(new RegExp('[ÉÈÊ]','gi'), 'e');
    text = text.replace(new RegExp('[ÍÌÎ]','gi'), 'i');
    text = text.replace(new RegExp('[ÓÒÔÕ]','gi'), 'o');
    text = text.replace(new RegExp('[ÚÙÛ]','gi'), 'u');
    text = text.replace(new RegExp('[Ç]','gi'), 'c');
    return text;                 
}
 function somenteNumeros(num) {
    var er = /[^0-9.]/;
    er.lastIndex = 0;
    var campo = num;
    if (er.test(campo.value)) {
      campo.value = "";
    }
}
function endsWithAny(suffixes, string) { // console.log(endsWithAny([".", "!", "?"], 'string?'));
    return suffixes.some(function (suffix) {
      return string.endsWith(suffix);
    });
}
// Função de deletar registro na DB por AJAX
// Retorno BOLEANO

function deletar_global(what=null,id=null,diretorio=null,elemento=null,oculta=false,refresh=false){
    var continuar = confirm('Tem certeza que deseja excluir?');
    if (continuar===false) {return false;}
    $.post(diretorio,{
        what: what,
        id: id,
    }, 
    function(resposta,status){
        console.log(resposta);
        if (status!='success') {alert('Não foi possivel fazer a requisição HTTP!');return false;}
        if (parseInt(resposta)==1){
            if (oculta===true) {
                document.getElementById(elemento).remove();
            }
            if (refresh===true){
                window.location.reload();
            }
        }else if (parseInt(resposta)==0){
            alert('Não foi possível excluir.');
        }else{
            alert('Valor retornado é desconhecido!');
        }
    });
}