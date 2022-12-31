<?php
function formataReais($valor1, $valor2, $operacao)
    {
    /*     function formataReais ($valor1, $valor2, $operacao)
    *
    *     $valor1 = Primeiro valor da operação
    *     $valor2 = Segundo valor da operação
    *     $operacao = Tipo de operações possíveis . Pode ser :
    *     "+" = adição,
    *     "-" = subtração,
    *     "*" = multiplicação
    *     "%" = porcentagem
    *
    */

    // Antes de tudo , arrancamos os "," e os "." dos dois valores passados a função . Para isso , podemos usar str_replace :
    // Script para substituir vírgula para ponto para valores abaixo de mil que tem o seguinte formato (0,10 - 100,00 - 999,99) ou seja que não tem ponto (resolver um bug de cálculo)
    if (strpos($valor1, ",") !== false && strpos($valor1, ".") === false) {
        $valor1 = str_replace(",", ".", $valor1);
    }
    else {
        $valor1 = str_replace (",", "", $valor1);
        $valor1 = str_replace (".", "", $valor1);
    }
    if (strpos($valor2, ",") !== false && strpos($valor2, ".") === false) {
        $valor2 = str_replace(",", ".", $valor2);
    }
    else {
        $valor2 = str_replace (",", "", $valor2);
        $valor2 = str_replace (".", "", $valor2);
    }

    // Agora vamos usar um switch para determinar qual o tipo de operação que foi definida :
    switch ($operacao) {
        // Adição :
        case "+":
            $resultado = $valor1 + $valor2;
            break;

        // Subtração :
        case "-":
            $resultado = $valor1 - $valor2;
            break;

        // Multiplicação :
        case "*":
            $resultado = $valor1 * $valor2;
            break;
        case "%":
            $resultado = $valor1 * $valor2 / 100;

    }

    //Arredondamento de valores que podem surgir nos cálculos como (3.607, 0.512)
    $resultado = round($resultado, 2); // Deixar somente duas casas decimais a frente depois do ponto (.)

    // Forçar entrada de valores 20.4 no "case 4", quando na verdade esses valores deviam ser 20.40 com duas casas a frente
    if (strpos($resultado, ".") !== false) {
        $dopontoadiante = strstr($resultado, "."); //Pegar os valores do ponto adiante
        
        $centavos = str_replace(".", "", $dopontoadiante); //Tirar o ponto e deixar só os centavos '00' ou '04'
        
        $tamCentavos = strlen($centavos);
        if ($tamCentavos == 1) {
            $centavos = $centavos."0"; //Adicionar o segundo zero caso tenha só um centavo de tamanho '0' ao invés de '00'
            
            $real = strstr($resultado, ".", true);
            
            $resultado = $real . $centavos; // se resultado antes era 20.4 agora passou a ser 20.40 ou 2040
        }
    }

    //Criar um script para remover os pontos do resultado (resolvendo o bug do calculo do valor que tem vírgula "0,10 - 100,00 - 999,99" abaixo de mil)
    $resultado = str_replace (",", "", $resultado);
    $resultado = str_replace (".", "", $resultado);

    // Calcula o tamanho do resultado com strlen
    $len = strlen ($resultado);

    // Novamente um switch , dessa vez de acordo com o tamanho do resultado da operação ($len) :
    // De acordo com o tamanho de $len , realizamos uma ação para dividir o resultado e colocar as vírgulas e os pontos
    switch ($len) {
        // 1 : 0,1,2,3,4,5,6,7,8,9 prevenção dos cálculos que retornam números individuais
        case "1":
            $retorna = "$resultado,00";
            break;

        // 2 : 0,99 centavos
        case "2":
            $retorna = "0,$resultado";
            break;

        // 3 : 9,99 reais
        case "3":
            $d1 = substr("$resultado",0,1);
            $d2 = substr("$resultado",-2,2);
            $retorna = "$d1,$d2";
            break;

        // 4 : 99,99 reais
        case "4":
            $d1 = substr("$resultado",0,2);
            $d2 = substr("$resultado",-2,2);
            $retorna = "$d1,$d2";
            break;

        // 5 : 999,99 reais
        case "5":
            $d1 = substr("$resultado",0,3);
            $d2 = substr("$resultado",-2,2);
            $retorna = "$d1,$d2";
            break;

        // 6 : 9.999,99 reais
        case "6":
            $d1 = substr("$resultado",1,3);
            $d2 = substr("$resultado",-2,2);
            $d3 = substr("$resultado",0,1);
            $retorna = "$d3.$d1,$d2";
            break;

        // 7 : 99.999,99 reais
        case "7":
            $d1 = substr("$resultado",2,3);
            $d2 = substr("$resultado",-2,2);
            $d3 = substr("$resultado",0,2);
            $retorna = "$d3.$d1,$d2";
            break;

        // 8 : 999.999,99 reais
        case "8":
            $d1 = substr("$resultado",3,3);
            $d2 = substr("$resultado",-2,2);
            $d3 = substr("$resultado",0,3);
            $retorna = "$d3.$d1,$d2";
            break;
        // 9 : 1.000.000,00 (1 milhão de reais)
        case "9":
            $d1 = substr("$resultado", 0, 1);
            $d2 = substr("$resultado", 1, 3);
            $d3 = substr("$resultado", 4, 3);
            $d4 = substr("$resultado", 7, 2);
            $retorna = "$d1.$d2.$d3,$d4";
            break;
        // 10 : 10.100.000,10 (dez milhões, cem mil e dez centavos)
        case "10":
            $d1 = substr("$resultado", 0, 2);
            $d2 = substr("$resultado", 2, 3);
            $d3 = substr("$resultado", 5, 3);
            $d4 = substr("$resultado", 8, 2);
            $retorna = "$d1.$d2.$d3,$d4";
            break;
        // 11: 100.100.000,10 (cem milhões, cem mil e dez centavos)
        case "11":
            $d1 = substr("$resultado", 0, 3);
            $d2 = substr("$resultado", 3, 3);
            $d3 = substr("$resultado", 6, 3);
            $d4 = substr("$resultado", 9, 2);
            $retorna = "$d1.$d2.$d3,$d4";
            break;
    }

    // Por fim , retorna o resultado já formatado
    return $retorna;
}

// Valores testados e aprovados:
// $exemplo = formataReais("1.000.000,00", "2,00", "%"); --> 20.000,00
// $exemplo = formataReais("500.000,00", "5,75", "%"); --> 28.750,00
// $exemplo = formataReais("100,00", "4,82", "%"); --> 
// $exemplo = formataReais("10,00", "0,82", "%"); --> 0,08
// $exemplo = formataReais("0,86", "2,00", "%"); --> 0,02

// echo $exemplo;
?>
