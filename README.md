# Desafio BIUD

Vocês podem acompanhar o que foi pedido [aqui](https://github.com/BIUD-Tech/vagas/tree/main/desafios/desenvolvedor-fullstack#desafio-fullstack-software-developer---biud)

## Instalação

Primeiro passo: Clonar o projeto

Na raiz do projeto:

```bash
yarn install --force
```
Para rodar o projeto é necessário ir em seu arquivo hosts e colocar 
o seguinte apontamento para o nginx 

```
127.0.0.1 desafio-guilherme.info
```
Após isso podemos subir nosso container:

```bash
docker-compose up --build
```
Teste o rabbitmq em [http://localhost:15672](http://localhost:15672)
###### user:guest
###### password:guest

na pasta raiz do projeto rode os seguintes comandos:


```
docker-compose exec php composer install
docker-compose exec php php bin/console doctrine:database:create
docker-compose exec php php bin/console doctrine:migrations:migrate
```
em uma outra aba do terminal, mas ainda na raiz do projeto, rode o comando:

```
yarn encore dev-server
```
NOTA: caso queira outro host no seu ambiente, é só trocar no arquivo nginx.conf 
e não se esqueça de atualizar nosso endpoint GraphQL em asset/service/client.js

Teste [http://desafio-guilherme.info](http://desafio-guilherme.info)

Após esses passos já temos o banco e as tabelas 

Para popular o nosso banco de dados podemos fazer de 2 maneiras:
Eu deixei alguns arquivos json na raiz do projeto que são modelos de requisição do ERP
O ERP escolhido por mim foi a shopfy, eu realizei testes direto na plataforma, por lá gratuitamente eu não consegui 
realizar a compra na loja, po´rem ao realizar o cadatro do webhook ele permite que eu envia requisições de teste com os produtos que eu tinha cadastrado na loja, 
esses arquivos json são essas requisições de teste que fui guardando em meu log e que usei para testar, pois minhas requisições de teste já tinha estourado na shopfy.

- `guilherme-peso50kg-e-bolafutebol.json`:
Nesse arquivo o usuario Guilherme compra um peso de 50kg e uma bolafutebol
- `guilherme-peso50kg-e-bolafutebol-order2.json`:
*Nesse arquivo eu realizo uma outra compra dos mesmos itens. 
*A compra possui codigo de referencia diferente*
- `john-camisa-cortavento.json`:
Usuario john compra uma camisa e um corta vento.
- `john-Chuteira-peso50kg.json`:
Aqui o usuario john compra uma chuteira e um peso50kg.

Podemos notar que o peso de 50kg foi comprado diversas vezes, nessa aplicação ele utiliza a requisição de compra para cadastrar o produto, 
então o certo é no fim desses casos de teste, termos 5 produtos

Preparei um script que pode fazer todas essas requisições de maneira rápida, porem fique a vontade para colar o 
conteudo do arquivo em algum cliente e fazer os testes detalhados, ou até mesmo apontar o webhook na shopfy, na opção de finalização de compra.

```
curl -X POST -H "Content-Type: application/json" -d @guilherme-peso50kg-e-bolafutebol.json http://desafio-guilherme.info/api/webhook
curl -X POST -H "Content-Type: application/json" -d @guilherme-peso50kg-e-bolafutebol-order2.json http://desafio-guilherme.info/api/webhook
curl -X POST -H "Content-Type: application/json" -d @john-camisa-cortavento.json http://desafio-guilherme.info/api/webhook
curl -X POST -H "Content-Type: application/json" -d @john-Chuteira-peso50kg.json http://desafio-guilherme.info/api/webhook 
```
Devemos lembrar que os produtos são processados pelo rabbitmq
caso tenha interesse de acompanhar é só entrar no [painel](http://localhost:15672) e verificar
antes de fazer as requisições devemos rodar ainda um comando que vai escutar esses processos

```
docker-compose exec php php bin/console messenger:consume
```
Após isso já podemos ver o funcionamento da nossa aplicação com o dashboard e a tela de consulta das compras

caso queira, também pode fazer requisições GraphQL pelo GRAPHIQL.

É só acessar nesse endereço: [http://desafio-guilherme.info/graphiql](http://desafio-guilherme.info/graphiql)
