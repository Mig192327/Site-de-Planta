<?php
session_start();
include('db.php');

// Verificando se o usuário já está logado
if (isset($_SESSION['user_id'])) {
    // Verifica se o usuário tem a role de admin e redireciona para o painel de admin
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin_panel.php'); // Página do painel de administração
    } else {
        header('Location: index.php'); // Redireciona para a página de notícias
    }
    exit();
}

// Processamento do login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Consultando o banco de dados para verificar as credenciais
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se o usuário for encontrado
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificando se a senha está correta
        if (password_verify($password, $user['password'])) {
            // Criando a sessão do usuário
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Verificando o papel do usuário e redirecionando
            if ($user['role'] === 'admin') {
                header('Location: admin_panel.php'); // Redireciona para o painel de admin
            } else {
                header('Location: index.php'); // Redireciona para a página de notícias
            }
            exit();
        } else {
            $error = 'Senha incorreta.';
        }
    } else {
        $error = 'Usuário não encontrado.';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> 
    <link rel="stylesheet" href="logins.css">
    <title>Login</title>
</head>
<body>
    <?php if (isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <div class="container">
        <div class="glassBox">
            <h2>Login</h2>
            <form method="POST" action="login.php">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required><br><br>

                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required><br><br>

                <button type="submit">Entrar</button>
            </form>
        </div>
    </div>
</body>
<style>


.oswald-<uniquifier> {
  font-family: "Oswald", sans-serif;
  font-optical-sizing: auto;
  font-weight: <weight>;
  font-style: normal;
}
h2{
    font-family: "Oswald", sans-serif;
  font-optical-sizing: auto;
  font-weight: 400;
  font-style: normal;
}
        body {
  font-family: "Oswald", sans-serif;
  font-optical-sizing: auto;
  font-weight: 400;
  font-style: normal;
          margin: 0;
            padding: 0;
            background-color: #EEEAE7;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border-radius:43px;
            
        }

        nav a {
            color: #EEEAE7;
            text-decoration: none;
            align-items:center;
            align-content: center;
            text-align: center;
            transition: color 0.3s;
        }

        nav a:active {
            color: #800000; /* Muda para vinho ao clicar */
        }

        

        h2, h3 {
            text-align: center;
            margin: 20px 0;
        }

        .news-container {
            border: 23px solid #ccc;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
        }

        .news-container h4 {
            color: #333;
        }

        .news-container p {
            color: #666;
        }

        .news-container img {
            width: 100%;
            max-width: 200px;
            border-radius: 5px;
        }
        #carousel-indicators{
            color: #000;
        }
        .links-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .links-container a {
            text-decoration: none;
        }

        .links-container a:first-child {
            color: blue;
        }

        .links-container a:nth-child(2) {
            color: green;
            margin-left: 10px;
        }

        hr {
            border: 1px solid #ddd;
        }
        .links-container {
    text-align: center;
    margin: 20px 0;
    font-family: "Rubik", sans-serif;
}

.links-container a {
    display: inline-block;
    margin: 0 10px;
    padding: 8px 16px;
    text-decoration: none;
    color: #444;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    font-size: 14px;
    transition: all 0.3s ease;
}

.links-container a:hover {
    background-color: #eee;
    color: #000;
    border-color: #999;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.links-container p {
    font-size: 14px;
    color: #666;
    margin: 5px 0;
}

.links-container p a {
    color: #444;
    text-decoration: underline;
    font-weight: bold;
}

.links-container p a:hover {
    color: #000;
}
.nav-item a.btn {
    margin: 0 5px;
    padding: 5px 10px;
    font-size: 14px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.nav-item a.btn:hover {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    opacity: 0.9;
}
.nav-tabs .nav-link {
    color: #333; /* Cor inicial dos links */
    text-decoration: none;
    font-weight: bold;
    padding: 10px 15px;
    transition: color 0.3s, background-color 0.3s;
}

.nav-tabs .nav-link:hover {
    color: #800000; /* Cor ao passar o mouse */
    background-color: #f0f0f0; /* Fundo ao passar o mouse */
    border-radius: 5px;
}

.nav-tabs .nav-link.active {
    color: white; /* Cor do texto do link ativo */
    background-color: #333; /* Fundo do link ativo */
    border-radius: 5px;
}


    </style>
    </html>
</html>
