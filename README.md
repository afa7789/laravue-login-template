# Web 
Laravel 8 + vue

- php >= 7.3
- sudo apt install php-xml
- sudo apt install php-mbstring

## Rodando Projeto local 

O projeto vue fica na pastas resources em vueapp.

- copiar o env.example para .env
- trocar os dados de banco para acessiveis por vc
- composer install
- php artisan migrate
- php artisan key:generate
- php artisan passport:install
- php artisan passport:keys
- php artisan db:seed
- cd resources/vueapp
- yarn install
- .env.example dar cp para .env.production.local e .env.development.local , colocar o NODE_ENV respectivo neles e as urls que deseja. TEM que ter o . na frente de env, tenha tenção ao copiar

## Usando Sail
para saber mais:
https://laravel.com/docs/8.x/sail

- o env já está configurado p/ isso.
`cp env.example .env`
- rodar o pacote do composer, que é uma blibioteca de php p/ modificar pacotes.
`composer install` or `composer update`
- criar um alias (Linux/MacOs)
`alias sail=./vendor/bin/sail`
`sail up -d`
- Caso não funcione use:
`sail up`
- Ai você pode ver aonde está o erro.
`sail artisan migrate`
`sail artisan key:generate`
`sail artisan passport:install`
`sail artisan passport:keys`
`sail artisan db:seed`
agora o front
`cd resources/vueapp`
`yarn install`
escolher entre produção ou dev
`cp .env.example .env.development.local`
`sed -i 's/||production//g' input.txt`
`yarn serve`

## Gerando documentação
Documentação está sendo gerada pelo phpDocumentor, eu gerei a documentação do que está presente apenas na pasta app.
https://www.phpdoc.org/

- php artisan l5-swagger:generate , p/ gerar código do swagger.

Traduções:
    - BackEnd so precisamos de trabalhar com as traduções dos emails
    - As mensagens de erro e sucesso é melhor de serem trabalhadas no Front, manter apenas o nome das string p/ ele buscar. (pensar sobre)