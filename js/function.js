$(function(){
  var data = new Date(); //Obter a data atual
  var mesAtual = data.getMonth()+8; // 0-11 (zero=janeiro)
  var diaAtual = data.getDate();
  //alert(mesAtual);
  $('#mes_'+mesAtual).show().find('.dia_'+diaAtual).addClass('atual');

  function hideShow(){
    if(mesAtual > 12){
        mesAtual = 1;
    }else if(mesAtual < 1){
        mesAtual = 12;
    }

    $('.mes').hide();
    $('#mes_'+mesAtual).show();
}

$('#vai').on('click', function(e){
    e.preventDefault();
    mesAtual++;
    hideShow();

    return false;
});

 $('#volta').on('click', function(e){
    e.preventDefault();
    mesAtual--;
    hideShow();

    return false;
  });
});