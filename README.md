## Tem o objetivo de:
- Compartilhar essa função em PHP que formata valores do real brasileiro

## Operações suportadas da função:
- A função suporta três parâmetros, sendo o primeiro e o segundo valores numéricos no formato do real brasileiro, já o terceiro vem a operação que se deseja fazer com esses dois números (suporta as operações de adição (+), subtração (-), multiplicação (*) e porcentagem (%))

## Exemplo de uso da função:
- Copie e cole a função em seu projeto
- Ative a função de acordo com os exemplos:
```
<?php
[...]
$exemplo = formataReais("1.000.000,00", "2,00", "%"); --> 20.000,00
$exemplo = formataReais("500.000,00", "5,75", "%"); --> 28.750,00
$exemplo = formataReais("100,00", "4,82", "%"); --> 
$exemplo = formataReais("10,00", "0,82", "%"); --> 0,08
$exemplo = formataReais("0,86", "2,00", "%"); --> 0,02

echo $exemplo;
?>
```

## Contato:
| Integrante | Usuário Git | E-mail para contato |
| --- | --- | --- |
| Leandro Lobo | [@LeandroLobo](https://github.com/bigolho16) | bigolho900@gmail.com |
