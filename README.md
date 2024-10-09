## Requisitos

- PHP 8+
- Composer
- Xampp
- Laravel
- Ngrok (para tunelamento HTTP)

## Como Rodar o Projeto

Primeiramente você vai criar uma aplicação no mercado livre pelo seguinte link: https://developers.mercadolivre.com.br/devcenter
Você loga e coloca as informações do seu perfil.

Na URI de Redirect é onde vamos ir pro proximo passo.

## Baixar e instalar xampp caso não tenha e o ngrok (por ele que vamos ter o certificado ssl)

instalado o xampp, você vai baixar o diretório laravel_application e coloca-lo dentro da pasta htdocs, que fica normalmente nesse caminho C:\xampp\htdocs e então dar start no apache e mysql do xampp
feito isso vamos configurar o .env que fica dentro do laravel_application. Lá você vai colocar as informações do banco com o seu banco que você vai criar com o phpmyadmin. você só precisa mudar o nome do banco e do user que normalmente é root. A senha por padrão é vazia.

feito isso abra o projeto no seu editor e certifique-se no terminal de estar na pasta /laravel_application/ para executar os comandos. Em seguida rode o servidor utilizando o comando php artisan serve.
0BS:. Caso ao rodar este comando ele não conseguir subir na porta 8000 e em nenhuma outra. Vá na pasta do php que o laravel estiver utilizando. Procure pelo .ini e dentro localize variables_order="EGPCS", mude o valor para GPCS e o problema talvez seja resolvido.

com o servidor rodando no 8000, agora você vai rodar o ngrok no prompt de comando, com o seguinte código ngrok http 8000 se tudo der certo você vai ter o URI de Redirect que vai ser o link com https
com este link você vai copiar e colar la na URI de Redirect da Aplicação do Mercado Livre mas lembrando de no fim do link adicionar o /callback ai o outro link obrigatório não importa muito, pode botar qualquer um que ele aceite.

feito a aplicação você vai ter o client_id e o secret, você vai copiar e colocar no .env do laravel_application. (client_id está como APP_ID no .env). Agora você vai no laravel_application/config/database.php linha 50 e 51 para botar suas informações do seu banco igual no .env.

após isso, no terminal certificando que esta no laravel_application/ você vai dar Ctrl+C para parar o php artisan serve (não pare o ngrok), em seguida execute o seguinte comando: php artisan migrate e depois o php artisan serve novamente. Agora seu banco de dados está com as tabelas criadas. copie o link https do ngrok e cole na url, antes de clicar no Botão login certifique-se que o .env está com as informações corretas, o URI_REDIRECT precisa ser exatamente o mesmo colocado no mercado livre. Após isso ao clicar no botão login você deve estar logado e autenticado. Ai já tera acesso aos recursos de criar e listar produtos.

## ATENÇÃO AO CRIAR PRODUTOS

A api do mercado livre exige que siga os requisitos a risca, lembre-se de escolher a categoria sempre permitida caso esteja com dificuldade um exemplo de categoria permitida é MLB455515.
https://api.mercadolibre.com/sites/MLB/categories aqui você pode conferir as categorias validas. Veja os atributos também, principalmente da faixa etária. Sugiro que siga o placeholder colocado.

Se a sua conta do mercado livre não tiver um endereço ele também dará erro. Certifique-se de adicionar um endereço no site do Mercado Livre.

Caso algo não esteja de acordo mande um email para mim guilherme.goncalves01@hotmail.com e eu ajudarei.
