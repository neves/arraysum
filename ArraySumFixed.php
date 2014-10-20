<?php

class ArraySum {
    public $count = 0;

    private $depth = 0;
    private $length = 0;

    private $chosen = array();
    private $valores = array();
    private $original = array();
    private $somas = array();
    private $output = array();

    const BLANK = '.';
    const OUT = '_';
    const IN = '+';

    public function __construct($valores) {
        $this->original = $valores;
        rsort($valores);
        $this->valores = SplFixedArray::fromArray($valores);
        $this->length = count($valores);
        $this->somas = array();
        $this->chosen = array_fill(0, $this->length, self::BLANK);
        $this->output = array_fill(0, $this->length, 0);

        for ($i = 0; $i < count($this->valores); $i++) {
            $this->somas[] = array_sum(array_slice($valores, $i));
        }
        $this->somas = SplFixedArray::fromArray($this->somas);
    }

    /**
     * $total Soma procurada
     * $i Índice do array para iniciar a busca
     */
    public function find($total, $i = 0) {
        //if ($i < 30) echo "\r".substr(implode('', $this->chosen), 0, 170).number_format($this->count). ' ' .$total;

        $this->count++;

        if ($i >= $this->length) return false;

        // se o total procurado é maior do que a soma abaixo, não irá encontrar nunca
        if ($total > $this->somas[$i]) return false;

        $current = $this->valores[$i];

        // se o total procurado é igual a soma abaixo, retorna o subarray abaixo
        //if ($total == $this->somas[$i]) return array_slice($this->valores, $i);

        // se o total procurado for igual ao valor atual, retorna um array contendo apenas ele
        if ($total == $current) {
            $this->output[$i] = $total;
            return true;
        }

        // procura uma soma existente que satisfaça este total
        //if (false !== ($key = array_search($total, $this->somas))) return array_slice($this->valores, $key);

        // procura um valor que satisfaça este total
        //if ($i < ($key = array_search($total, $this->valores))) return array($this->valores[$key]);

        // se o total é menor que o número atual, então ele não faz parte na soma, descer e procurar abaixo

        if ($this->find($total, $i + 1)) return true;

        $this->output[$i] = $current;

        if ($this->find($total - $current, $i + 1)) {
            return true;
        }

        $this->output[$i] = 0;

        return false;
    }

    public function result() {
        return array_filter($this->output, function($n) {return $n > 0;});
    }

    public function filter($total) {
      $soma = $this->find($total);
      $filtered = array();
      foreach($this->original as $k => $v) {
        if (false !== $key = array_search($v, $soma)) {
          $filtered[$k] = $v;
          unset($soma[$key]);
        }
      }

      if ($soma) {
        throw new DomainException("Sum returned values not present in original array: " . implode(',', $soma));
      }

      return $filtered;
    }

    public function test($total, $expected = []) {
        $this->count = 0;
        $this->depth = 0;
        $result = $this->find($total);
        if ($result == $expected) {
            echo "ok $total\tx$this->count\n";
        } else {
            echo "ERRO\n";
            //echo "error: $total ".var_export($result, true);
        }

        return $result;
    }
}
