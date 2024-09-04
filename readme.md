# 30.19 - Composer
O composer é o gerenciador de pacotes utilizado pelo PHP.
Além dos pacotes, podemos mapear os namespaces de nossa aplicação, facilitando e deixando o
desenvolvimento mais prazeroso.

O composer foi fortemente inspirado pelo `npm` do node.js e pelo `bundler` do ruby.

## Principais comandos
O composer possui uma quantidade de comandos muito grande, porém inicialmente vamos focar em 4
* `require`:  Adiciona a library no `composer.json` e faz a instalação
* `install`: Instala todas as libraries listadas no `composer.json`
* `update`: Atualiza todas as libraries listadas no `composer.json`
* `uninstall`: Desinstala uma lib e a remove do `composer.json`