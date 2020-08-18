<?php
  function num($num){
    return ($num < 10) ? '0'.$num : $num;
  }

  function montaEventos($info){
    global $pdo;
    //tabela,data,titulo
    $tabela = $info['tabela'];
    $data = $info['data'];
    $titulo = $info['titulo'];
    $link = $info['link'];

    //$now = date('Y-m-d);

    $eventos = $pdo->prepare("SELECT * FROM '".$tabela."' WHERE '".$data."' >=NOW()");
    $eventos->execute();

    $retorno = array();
    while($row = $eventos->fetchObject()){
      $dataArr = date('Y-m-d', strtotime($row->{$data}));
      $retorno[$dataArr] = array(
        'titulo' =>$row ->{$titulo},
        'link' =>$row ->{$link}
      );
    }
    return $retorno;
  }
  //para saber quantos dias do ano possui ex: em 2016 em fevereiro teve 29 dias...
  function diasMeses(){
    $retorno = array();

    for($i = 1; $i<=12;$i++){
      //cal = calendario, days in month = dias do ano.
      $retorno[$i] = cal_days_in_month(CAL_GREGORIAN, $i, date('Y'));
    }

    return $retorno;

  }
  
  /*[
    '2020-08-15'=>[
      'titulo'=> 'titulo'
      'link'=> 'link em si'
    ]

  ]*/

  /*função para montar calendario com ($daysweek = array = para usar em ingles com
  3 caracteres*/
  function montaCalendario($eventos = array()){
    $daysWeek = array(
        'Sun',
        'Mon',
        'Tue',
        'Wed',
        'Thu',
        'Fri',
        'Sat'
    );
    /*para monstrar as colunas quando tiver montando o calendario.
    não precisa colocar os nomes completos pode deixar abreviado com três caract
     para ficar mais facil no style*/
    $diasSemana = array(
      'Dom',
      'Seg',
      'Ter',
      'Qua',
      'Qui',
      'Sex',
      'Sab'
  );
  //para guarda os meses em sí, e nomear as colunas
  $arrayMes = array(
    1 => 'Janeiro',
    2 => 'Fevereiro',
    3 => 'Março',
    4 => 'Abril',
    5 => 'Maio',
    6 => 'Junho',
    7 => 'Julho',
    8 => 'Agosto',
    9 => 'Setembro',
    10 => 'Outubro',
    11 => 'Novembro',
    12 => 'Dezembro'
  );
  //para guarda o retorno da função dias e meses.
  $diasMeses = diasMeses();
  $arrayRetorno = array();

  for ($i =1; $i <= 12; $i++){
    $arrayRetorno[$i] = array();
    for($n=1; $n<= $diasMeses[$i]; $n++){
      $dayMonth = gregoriantojd($i, $n, date('Y'));
      $weekMonth = substr(jddayofweek($dayMonth, 1),0,3);
      if($weekMonth =='Mun') $weekMonth = 'Mon';
      $arrayRetorno[$i][$n] = $weekMonth;
    }
  }

  //entra com a funções HTML E CSS
  echo '<a href="#" id="volta">&laquo;</a><a href="#" id="vai">&raquo;</a>';
  echo '<table border="0" width="100%">';
  foreach($arrayMes as $num => $mes){
    echo '<tbody id="mes_'.$num.'"class="mes">';
    echo '<tr class="mes_title"><td colspan="7">'.$mes.'</td></tr>';
    echo '<tr class="dias_title">';
    foreach($diasSemana as $i => $day){
      echo '<td>'.$day.'</td>';
    }
    echo '</tr><tr>';
    $y = 0;
    foreach($arrayRetorno[$num] as $numero => $dia){
      $y++;
      if($numero == 1){
        $qtd = array_search($dia, $daysWeek);
        for($i=1; $i<=$qtd; $i++){
          echo '<td></td>';
          $y+=1;
        }
      }
      if(count($eventos) > 0){
        $month = num($num);
        $dayNow = num($numero);
        $date = date('Y').'-'.$month.'-'.$dayNow;
        if(in_array($date, array_keys($eventos))){
          $evento = $eventos[$date];
          echo '<td class="evento"><a href="'.$eventos['link'].'" title="'.$eventos['titulo'].'">'.$numero.'</a></td>';
        }else{
          echo '<td class="dia_'.$numero.'">'.$numero.'</td>';
        }
      }else{
        echo '<td class="dia_'.$numero.'">'.$numero.'</td>';
      }
      if($y == 7){
        $y=0;
        echo '</tr><tr>';
      } 
    }
    echo '</tr></tbody>';
  }
  echo '</table>';
  }
?>