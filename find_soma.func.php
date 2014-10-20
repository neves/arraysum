<?php

function remove_maiores_que($total, $numeros) {
    return array_filter($numeros, function($n) use ($total) {
        return $n <= $total;
    });
}


$GLOBALS['i'] = 0;
$GLOBALS['c'] = 0;
$GLOBALS['n'] = array();

function sequence_find_soma($sub_total, $numeros) {
    $sub = array();
    while($numeros) {
        array_unshift($sub, array_pop($numeros));
        $soma = find_soma($sub_total, $sub);
        if ($soma) {
            return $soma;
        }
    }
    return array();
}

function print_status() {
    return;
    echo "\r";
    echo implode('', $GLOBALS['n']).'|';
}

function find_soma2($total, $numeros) {
    $subset = array();
    while (end($numeros)) {
        $key = key($numeros);
        $n = array_pop($numeros);
        $subset[$key] = $n;
        if (array_sum($subset) >= $total) {
            asort($subset);

            $keys = array_keys($subset);
            $values = array_fill(0, count($keys), ' ');
            $GLOBALS['n'] = array_combine($keys, $values);
            var_dump(count($subset));
            $array = find_soma($total, $subset);
            if ($array) return $array;
        }
    }
    return array();
}

function find_soma($total, $numeros) {
    if ($total <= 0) {
        return array();
    }

    // primeiro remove os numeros maiores que o total buscado
    $numeros = remove_maiores_que($total, $numeros);

    $sum = array_sum($numeros);

    // já achou o array
    if ($sum == $total) {
        return $numeros;
    }

    // se a soma de todos elementos do array for inferior ao total, não adianta procurar
    if ($sum < $total) {
        return array();
    }

    // remove o maior e procura soma do restante
    while( end($numeros) !== false ) { // enquanto tiver numeros no array
        // remove o maior e sua respectiva chave
        $key = key($numeros);
        $n = array_pop($numeros);

        // verifica se o numero já é igual ao total
        if ($n == $total) {
            return array($key => $n);
        }

        $GLOBALS['n'][$key] = '+';
        print_status();

        // no array que sobrou, procura pela diferença do total e o número maior removido acima
        $sub_total = $total - $n;

        if (!empty($numeros)) {
            $soma = find_soma($sub_total, $numeros);
        }

        $GLOBALS['n'][$key] = ' ';
        print_status();

        // se a soma não for vazia, então encontrou a sub soma
        if ( ! empty($soma) ) {
            // adiciona o numero atual no final da soma e retorna
            $soma[$key] = $n;
            return $soma;
        }
    }

    // retorna array vazio indicando que não encontrou nenhuma soma
    return array();
}
