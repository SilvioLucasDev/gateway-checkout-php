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
<br>Estava com dificuldade em utilizar o .htaccess; incluí no Dockerfile o comando para habilitar o modo de rewrite do Apache.
<br>Não consegui modificar o id da tabela registros para AUTO INCREMENT; criei um método no repository que pega o último id e fiz um incremento dentro da model Record.
<br>Minha maior dificuldade foi desenvolver a configuração de rotas, request e response, pois não estava satisfeito com o que eu conhecia, então decidi aprender novas formas de implementar.
<br>Optei por desenvolver em PHP mas, utilizei o Laravel como referência em alguns momentos.
<br>Atualizei o PHP do docker-compose.yml para a versão 8.2.
<br>No desenvolvimento, busquei aplicar os princípios de SOLID e Clean Code.
<br>Utilizei o designer partner Factory para realizar a injeção de dependência do repository na controller.
<br>Utilizei o designer partner Singleton no helper de conexão com o banco de dados para garantir que a classe tenha somente uma instância.

## Regras de negócios para identificação do denunciante (Criadas por mim, Silvio.)
<br> **1 -** A identidade do denunciante é opcional ao criar um registro. Se a identidade não for fornecida, o campo `is_identified` deve ser definido como `0`. Se a identidade for fornecida, o campo `is_identified` deve ser definido como 1.
<br> **2 -** Se o campo `is_identified` for definido como `1`, os campos `whistleblower_name` e `whistleblower_birth` são obrigatórios.
<br> **3 -** Após a criação do registro, se o usuário desejar associar um denunciante a ele, deve preencher os campos `whistleblower_name` e `whistleblower_birth`, juntamente com o campo `is_identified` definido como `1` para que a operação seja válida.
<br> **4 -** O usuário tem a opção de desativar a identificação do denunciante definindo `is_identified` como `0`, porém os campos `whistleblower_name` e `whistleblower_birth` devem continuar preenchidos.
<br> **5 -** O usuário pode reativar a identificação do denunciante definindo `is_identified` como `1`, mantendo os dados anteriores nos campos `whistleblower_name` e `whistleblower_birth`, ou enviando novos dados.
<br> **6 -** O usuário pode modificar os campos `whistleblower_name` e `whistleblower_birth`, mas a identificação só será válida se o valor de `is_identified` for igual a `1`.

## Rotas

### Listar Registros

Rota para listar registros com e sem filtro.

- **Método:** GET
- **URL:** `http://localhost:8000/api/registros`
- **Parâmetros de Consulta:**
  - `deleted`: Boolean
  - `type`: String
  - `order_by`: String
  - `limit`: Number
  - `offset`: Number

### Listar um Único Registro

Rota para listar um único registro.

- **Método:** GET
- **URL:** `http://localhost:8000/api/registros/{id: Number}`

### Criar um Registro

Rota para criar um novo registro.

- **Método:** POST
- **URL:** `http://localhost:8000/api/registros`
- **Corpo da Requisição:**
  ```json
  {
    "type": "String (Obrigatório)",
    "message": "String (Obrigatório)",
    "is_identified": "Boolean (Obrigatório)",
    "whistleblower_name": "String (Opcional)",
    "whistleblower_birth": "String (Opcional)"
  }

- Se is_identified for 1, whistleblower_name e whistleblower_birth são obrigatórios.

### Deletar um Registro

Rota para deletar um registro.

- **Método:** DELETE
- **URL:** `http://localhost:8000/api/registros/{id: Number}`

### Atualizar um Registro

Rota para atualizar um registro.

- **Método:** PUT
- **URL:** `http://localhost:8000/api/registros/{id: Number}`
- **Corpo da Requisição:**
  ```json
  {
    "type": "String (Obrigatório)",
    "message": "String (Obrigatório)",
    "is_identified": "Boolean (Obrigatório)",
    "whistleblower_name": "String (Opcional)",
    "whistleblower_birth": "String (Opcional)"
  }

### Atualizar Parcialmente um Registro

Rota para atualizar parcialmente um registro.

- **Método:** PATCH
- **URL:** `http://localhost:8000/api/registros/{id: Number}`
- **Corpo da Requisição:**
  ```json
  {
    "type": "String (Opcional)",
    "message": "String (Opcional)",
    "is_identified": "Boolean (Opcional)",
    "whistleblower_name": "String (Opcional)",
    "whistleblower_birth": "String (Opcional)"
  }

