
var produtos = [];
    
    produtos['nome'] = [];
    produtos['precos'] = [];

    lista_coisas['nome'][1] = 'Arroz';
    lista_coisas['nome'][2] = 'Cafe';
    lista_coisas['nome'][3] = 'Feijao';

    lista_coisas['precos'][1] = '30R$';
    lista_coisas['precos'][2] = '15R$';
    lista_coisas['precos'][3] = '5R$';



function exibeLista(){

  var lista = document.getElementById('listas').value; 

  switch (lista){
    case '1':
      document.getElementById("conteudo-lista").innerHTML = 'Arroz - 30R$' + '<br/>' + 'Feijao - 15R$' + '<br/>' + 'Acucar - 10R$' + '<br/>' + 'Cafe - 18R$';
    break;

    case '2':
      document.getElementById("conteudo-lista").innerHTML = 'Produto 1 - 30R$' + '<br/>' + 'Produto 2 - 15R$' + '<br/>' + 'Produto 3 - 10R$' + '<br/>' + 'Produto 4 - 18R$';
    break;

    case '3':
      document.getElementById("conteudo-lista").innerHTML = 'Produto 4 - 30R$' + '<br/>' + 'Produto 9 - 15R$' + '<br/>' + 'Produto 10 - 10R$' + '<br/>' + 'Produto 6 - 18R$';
    break;

    case '4':
      document.getElementById("conteudo-lista").innerHTML = 'Lista Vazia';
    break;

    case '5':
      document.getElementById("conteudo-lista").innerHTML = 'Lista Vazia';
    break;

    default:
    break;
  }
  
  
}

function checkOut(){
  var lista = document.getElementById('listas').value; 
  

}















function criaBotaoWishList(qntd_itens){

  for(var i = 1; i <= qntd_itens; i++){
    var botao = document.createElement("button");
    botao.value = "Add to Wishlist";    
  }

  document.getElementById('myTabContent').appendChild(botao);
}


function test(){
  
  var produto = parseFloat(document.getElementById('nome').value);
  //document.getElementById("demo").innerHTML = "Test" + produto;
  document.write(produto);
}




