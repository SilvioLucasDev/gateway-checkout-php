<?php

// Nesse arquivo constam alguns exemplos. Caso use um framework, sinta-se livre para substituir esse arquivo.

// Caso não consiga utilizar o SQLite (esperamos que consiga), vamos disponibilizar um array com os dados
// para ser utilizado como um "database fake" no arquivo registros.php.

// Exemplo de conexão com o SQLite usando PDO (referência: https://www.php.net/manual/pt_BR/ref.pdo-sqlite.php)
try {
    $pdo = new PDO(
        'sqlite:../data/db.sqlite',
        '',
        '',
        [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ]
    );
    
    $query = "SELECT * FROM registros";
    $stmt = $pdo->query($query);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<pre>';
        print_r($row);
        echo '</pre>';
    }
} catch (\Throwable $th) {
    echo 'Erro na conexão: ' . $e->getMessage();
}
