# Desafio | Backend

O desafio consiste em usar a base de dados em SQLite disponibilizada e criar uma **rota de uma API REST** que **liste e filtre** todos os dados. Serão 10 registros sobre os quais precisamos que seja criado um filtro utilizando parâmetros na url (ex: `/registros?deleted=0&type=sugestao`) e retorne todos resultados filtrados em formato JSON.

Você é livre para escolher o framework que desejar, ou não utilizar nenhum. O importante é que possamos buscar todos os dados acessando a rota `/registros` da API e filtrar utilizando os parâmetros `deleted` e `type`.

* deleted: Um filtro de tipo `boolean`. Ou seja, quando filtrado por `0` (false) deve retornar todos os registros que **não** foram marcados como removidos, quando filtrado por `1` (true) deve retornar todos os registros que foram marcados como removidos.
* type: Categoria dos registros. Serão 3 categorias, `denuncia`, `sugestao` e `duvida`. Quando filtrado por um `type` (ex: `denuncia`), deve retornar somente os registros daquela categoria.

O código deve ser implementado no diretorio /source. O bando de dados em formato SQLite estão localizados em /data/db.sq3.

Caso tenha alguma dificuldade em configurar seu ambiente e utilizar o SQLite, vamos disponibilizar os dados em formato array. Atenção: dê preferência à utilização do banco SQLite.

Caso você já tenha alguma experiência com Docker ou queira se aventurar, inserimos um `docker-compose.yml` configurado para rodar o ambiente (utilizando a porta 8000).

Caso ache a tarefa muito simples e queira implementar algo a mais, será muito bem visto. Nossa sugestão é implementar novos filtros (ex: `order_by`, `limit`, `offset`), outros métodos REST (`GET/{id}`, `POST`, `DELETE`, `PUT`, `PATCH`), testes unitários etc. Só pedimos que, caso faça algo do tipo, nos explique na _Resposta do participante_ abaixo.

# Resposta do participante
_Responda aqui quais foram suas dificuldades e explique a sua solução_
Estava com dificuldade em utilizar o SQLite; modifiquei a extensão do arquivo para .sqlite.
Estava com dificuldade em utilizar o .htaccess; incluí no Dockerfile o comando para habilitar o modo de rewrite do Apache.
Não consegui modificar o id da tabela registros para AUTO INCREMENT, criei um método no repository que pega o último id e fiz um incremento dentro da model Record.


// -> PENDENTE
EXPLICAR DEPOIS OQUE EU FIZ DE ADICIONAL NA APLICAÇÃO (OPTEI POR ATUALIZAR O PHP DO docker-compose)

CONTROLLER: REMOVER VALIDAÇÃO DA CONTROLLER E COLOCAR EM UM ARQUIVO SEPARADO?
CONTROLLER: CRIAR UMA CLASSE PARA CENTRALIZAR A VALIDAÇÃO DE ERROS?

ALL: UTILIZAR INJEÇÃO DE DEPENDÊNCIA
ALL: CRIAR ERROS ESPECÍFICOS
ALL: DEIXAR TUDO EM INGLÊS
ALL: ADICIONAR TESTES
ALL: TIPAR TUDO

MELHORAR VALIDAÇÕES DE RETURNO

REPOSITORY: CRIAR HELPERS PARA CONSULTAS?
MOVER THROWS DA CONTROLLER PARA O REPOSITORY?

UTILIZAR A CONEXÃO COM O DB NA CONSTRUCT
MELHORAR CLASSE DO DB?
MELHORAR ENTITY
CRIAR UM SWAGGER
HOSPEDAR NO RENDER
