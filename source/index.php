<?php

// Nesse arquivo constam alguns exemplos. Caso use um framework, sinta-se livre para substituir esse arquivo.

// Caso não consiga utilizar o SQLite (esperamos que consiga), vamos disponibilizar um array com os dados
// para ser utilizado como um "database fake" no arquivo registros.php.

// Exemplo de conexão com o SQLite usando PDO (referência: https://www.php.net/manual/pt_BR/ref.pdo-sqlite.php)

$pdo = new PDO(
    'sqlite:../data/db.sq3',
    '',
    '',
    [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    ]
);
