# Back-End do Sistema Cidadão de Olho

Esse projeto foi realizado para um processo seletivo da empresa **Codificar Sistemas Tecnológicos de Belo Horizonte - MG**

# OBJETIVO

Desenvolver uma API, com apenas 2 rotas. Uma para mostrar os top 5 deputados que mais pediram reembolso de verbas indenizatórias por mês, considerando somente o ano de 2019. E outra para mostrar o ranking das redes sociais mais utilizadas dentre os deputados, ordenado de forma decrescente.

# COMO EXECUTAR O SISTEMA LOCALMENTE

 - Você de ter o docker instalado na sua maquina. Link para instalar o docker no Windows: [https://docs.docker.com/docker-for-windows/install/](https://docs.docker.com/docker-for-windows/install/)
 - Apos a instalação do docker, instale o docker compose. Link: [https://docs.docker.com/compose/install/](https://docs.docker.com/compose/install/)
 - Deve realizar o clone do projeto no seu computador, para a pasta "cidadao" utilizando o comando a seguir:
 `git clone https://github.com/wesleyvieira12/cidadao_de_olho.git cidadao`
 - Entre na pasta "cidadao", com o comando: `cd cidadao`
 - Execute o comando: `docker-compose up -d`
 Se tudo ocorrer corretamente aparecerá no seu terminar o seguinte texto, que mostra que todos os containers subiram corretamente:
 **Creating redis      ... done
Creating mysql ... done
Creating phpmyadmin ... done
Creating php-fpm    ... done
Creating supervisor ... done
Creating nginx      ... done**
	 
 - Apos o termino da execução do comando anterior, você deve entrar no container "php-fpm", para que possa popular o seu banco rapidamente, pois caso não realize esse passo, você deverá esperar até 00h, pois os comandos que populam as tabelas só executam de 22h às 00h. Para entrar no container você deve utilizar o comando: `docker exec -it php-fpm bash`
 - Agora que você está dentro do container, execute o comando: `php artisan update:deputies`
 - Após executar o comando anterior execute ainda dentro do container: `php artisan update:amounts`
 - Caso o passo 7 ou 8 dê algum erro execute-os novamente, pois a api, pode estar sobrecarregada.
 
 # ROTAS E LINKS
Após a execução correta dos comandos você poderá acessar os recursos do sistema através de alguns links e rotas 

 Rota para mostrar os top 5 deputados que mais pediram reembolso de verbas indenizatórias por mês, considerando somente o ano de 2019:
 - http://localhost:8080/api/deputies/top-five

Rota para mostrar o ranking das redes sociais mais utilizadas dentre os deputados, ordenado de forma decrescente:
 - http://localhost:8080/api/social-networks/ranking

Link para acessar o sistema do supervisor ( usuario: root, senha: root ):
 - http://localhost:9001

Link para acessar o sistema do phpMyAdmin (servidor: mysql, usuario: root , senha: Moderador12@ ):

 - http://localhost:8081