<?php

require_once('function.php');

class Functions
{
    public function registerUser($args)
    {
        $name = $args['name'];
        $email = $args['email'];
        $password = cryptS($args['password']);
        $cpf = clearString($args['cpf']);

        require_once('../src/conn/conn.php');
        $conn = Database::connectionPDO();

        $sql = $conn->prepare("SELECT email AS email FROM usuarios WHERE email = :email");
        $sql->bindParam(':email', $email);
        $sql->execute();
        $verifyEmail = $sql->fetchColumn();

        $sql = $conn->prepare("SELECT cpf AS CPF FROM usuarios WHERE cpf = :cpf");
        $sql->bindParam(':cpf', $cpf);
        $sql->execute();
        $verifyCPF = $sql->fetchColumn();

        if ($verifyEmail || $verifyCPF > 0) {
            throw new Exception("E-mail ou CPF já cadastrados!");
        }

        try {
            $sql = $conn->prepare("INSERT INTO usuarios (nome, email, senha, cpf) VALUES (:name, :email, :password, :cpf)");
            $sql->bindParam(':name', $name);
            $sql->bindParam(':email', $email);
            $sql->bindParam(':password', $password);
            $sql->bindParam(':cpf', $cpf);
            $sql->execute();

            return true;
        } catch (exception $e) {
            return "Erro: {$e}";
        }
    }

    public function loginClient($args)
    {
        session_start();

        $email = $args['email'];
        $password = cryptS($args['password']);

        require_once('../src/conn/conn.php');
        $conn = Database::connectionPDO();

        $sql = $conn->prepare("SELECT email AS email, senha FROM usuarios WHERE email = :email AND senha = :password");
        $sql->bindParam(':email', $email);
        $sql->bindParam(':password', $password);
        $sql->execute();
        $verifyLogin = $sql->fetchColumn();

        if ($verifyLogin <= 0) {
            throw new Exception("E-mail ou senha inválidas!");
        }

        try {
            $sql = $conn->prepare("SELECT id AS id, email AS email, senha FROM usuarios WHERE email = :email AND senha = :password");
            $sql->bindParam(':email', $email);
            $sql->bindParam(':password', $password);
            $sql->execute();
            $getUserId = $sql->fetchAll();

            foreach ($getUserId as $user) {
                $getUserId['id'] = cryptS($user['id']);
            }

            $sessao = $_SESSION["conectado"] = true;
            return array($sessao, cryptS($user['id']));

        } catch (exception $e) {
            return "Erro: {$e}";
        }
    }

    public function verificaAcesso()
    {
        //teste para validarmos o acesso do usuário ao conteúdo restrito
        if (!isset($_SESSION['conectado']) or $_SESSION['conectado'] != true) {
            //temos um acesso indevido do usuário. Encerramos a aplicação
            header('Location: ../../src/pages/error404.php');
            exit();
        }
    }

    public function getUser($user)
    {
        $user = descryptS($user);

        require_once('../src/conn/conn.php');
        $conn = Database::connectionPDO();

        try {
            $sql = $conn->prepare("SELECT concat(Upper(substr(nome, 1,1)), lower(substr(nome, 2,length(nome)))) AS name FROM usuarios WHERE id = :user");
            $sql->bindParam(':user', $user);
            $sql->execute();
            $getUserId = $sql->fetch(PDO::FETCH_ASSOC);

            return $getUserId;
        } catch (exception $e) {
            return "Erro: {$e}";
        }
    }

    public function searchCollaborators($args)
    {
        require_once('../src/conn/conn.php');
        $conn = Database::connectionPDO();

        $limit = $args['limit'];
        $page = $args['page'];
        $search = $args['search'];
        $search = "%$search%";

        if ($limit)
            $current = $limit * ($page - 1);

        try {
            $sql = "SELECT id AS id, nome AS nome, sobrenome AS sobrenome, CEP AS CEP, cidade AS cidade, estado AS estado, logradouro AS logradouro, numero AS numero, bairro AS bairro, complemento AS complemento from colaboradores WHERE
            nome LIKE :search
            OR sobrenome LIKE :search
            OR cidade LIKE :search
            OR CEP LIKE :search;";

            if ($limit)
                $sql .= ' ORDER BY nome DESC LIMIT :current, :limit';

            $code = $conn->prepare($sql);
            $code->bindParam(':search', $search);
            $code->bindParam(':limit', $limit, PDO::PARAM_INT);
            $code->bindParam(':current', $current, PDO::PARAM_INT);
            $code->execute();
            $search = $code->fetchAll(PDO::FETCH_ASSOC);

            foreach ($search as $key => $cryptsID) {
                $search[$key]['id'] = cryptS($cryptsID['id']);
            }

            return $search;
        } catch (exception $e) {
            return "Erro: {$e}";
        }
    }
    
    public function getCollaborators($args)
    {
        $limit = $args['limit'];
        $page = $args['page'];

        require_once('../src/conn/conn.php');
        $conn = Database::connectionPDO();

        if ($limit)
            $current = $limit * ($page - 1);

        try {
            $sql = "SELECT id AS id, nome AS nome, sobrenome AS sobrenome, CEP AS CEP, cidade AS cidade, estado AS estado, logradouro AS logradouro, numero AS numero, bairro AS bairro, complemento AS complemento from colaboradores";

            if ($limit)
                $sql .= ' ORDER BY nome DESC LIMIT :current, :limit';

            $code = $conn->prepare($sql);
            $code->bindParam(':limit', $limit, PDO::PARAM_INT);
            $code->bindParam(':current', $current, PDO::PARAM_INT);
            $code->execute();
            $getCollaborators = $code->fetchAll(PDO::FETCH_ASSOC);

            foreach ($getCollaborators as $key => $collaborators) {
                $getCollaborators[$key]['id'] = cryptS($collaborators['id']);
            }

            return $getCollaborators;
        } catch (exception $e) {
            return "Erro: {$e}";
        }
    }

    public function loadChart()
    {
        require_once('../src/conn/conn.php');
        $conn = Database::connectionPDO();

        try {
            $sql = $conn->prepare("SELECT COUNT(nome) AS collaborators FROM colaboradores");
            $sql->execute();
            $getNumberCollaborators = $sql->fetch(PDO::FETCH_ASSOC);

            $result = array(
                'collaborators' => $getNumberCollaborators,
            );

            return $result;
        } catch (exception $e) {
            return "Erro: {$e}";
        }
    }

    public function registrationCollaborators($args)
    {
        $password = $args['password'];
        $user = descryptS($args['user']);
        $nome        = $args['nome'];
        $sobrenome   = $args['sobrenome'];
        $CEP         = $args['CEP'];
        $cidade      = $args['cidade'];
        $estado      = $args['estado'];
        $logradouro  = $args['logradouro'];
        $numero      = $args['numero'];
        $bairro      = $args['bairro'];
        $complemento = $args['complemento'];

        require_once('../src/conn/conn.php');
        $conn = Database::connectionPDO();

        if (!verifyPassword($password, $user)) {
            throw new Exception("Senha incorreta");
            // exit;
        }

        $sql = $conn->prepare("INSERT INTO colaboradores (nome, sobrenome, CEP, cidade, estado, logradouro, numero, bairro, complemento) VALUES (:nome, :sobrenome, :CEP, :cidade, :estado, :logradouro, :numero, :bairro, :complemento)");
        $sql->bindParam(':nome', $nome);
        $sql->bindParam(':sobrenome', $sobrenome);
        $sql->bindParam(':CEP', $CEP);
        $sql->bindParam(':cidade', $cidade);
        $sql->bindParam(':estado', $estado);
        $sql->bindParam(':logradouro', $logradouro);
        $sql->bindParam(':numero', $numero);
        $sql->bindParam(':bairro', $bairro);
        $sql->bindParam(':complemento', $complemento);
        $sql->execute();

        return true;
    }
    
    public function editCollaborators($args)
    {
        $user = descryptS($args['user']);
        $id = descryptS($args['id']);

        $nome        = $args['nome'];
        $sobrenome   = $args['sobrenome'];
        $CEP         = $args['CEP'];
        $cidade      = $args['cidade'];
        $estado      = $args['estado'];
        $logradouro  = $args['logradouro'];
        $numero      = $args['numero'];
        $bairro      = $args['bairro'];
        $complemento = $args['complemento'];
        $password    = $args['password'];

        require_once('../src/conn/conn.php');
        $conn = Database::connectionPDO();

        if (!verifyPassword($password, $user)) {
            throw new Exception("Senha incorreta");
            // exit;
        }

        try {
            $sql = $conn->prepare('UPDATE colaboradores SET nome = :nome, sobrenome = :sobrenome, CEP = :CEP, cidade = :cidade, estado = :estado, logradouro = :logradouro, numero = :numero, bairro = :bairro, complemento = :complemento WHERE id = :id');
            $sql->bindParam(':id', $id);
            $sql->bindParam(':nome', $nome);
            $sql->bindParam(':sobrenome', $sobrenome);
            $sql->bindParam(':CEP', $CEP);
            $sql->bindParam(':cidade', $cidade);
            $sql->bindParam(':estado', $estado);
            $sql->bindParam(':logradouro', $logradouro);
            $sql->bindParam(':numero', $numero);
            $sql->bindParam(':bairro', $bairro);
            $sql->bindParam(':complemento', $complemento);
            $sql->execute();

            return true;
        } catch (exception $e) {
            return "Erro: {$e}";
        }
    }

    public function deleteCollaborators($args)
    {
        $user = descryptS($args['user']);
        $id = descryptS($args['id']);
        $password = $args['password'];

        require_once('../src/conn/conn.php');
        $conn = Database::connectionPDO();

        if (!verifyPassword($password, $user)) {
            throw new Exception("Senha incorreta");
            // exit;
        }

        try {
            $sql = $conn->prepare("DELETE from colaboradores WHERE id = :id");
            $sql->bindParam(':id', $id);
            $sql->execute();

            return true;
        } catch (exception $e) {
            return "Erro: {$e}";
        }
    }

    public function getUsers($args)
    {
        $limit = $args['limit'];
        $page = $args['page'];

        require_once('../src/conn/conn.php');
        $conn = Database::connectionPDO();

        if ($limit)
            $current = $limit * ($page - 1);

        try {
            $sql = "SELECT nome AS name, email AS email, cpf AS cpf from usuarios";

            if ($limit)
                $sql .= ' ORDER BY name DESC LIMIT :current, :limit';

            $code = $conn->prepare($sql);
            $code->bindParam(':limit', $limit, PDO::PARAM_INT);
            $code->bindParam(':current', $current, PDO::PARAM_INT);
            $code->execute();
            $getUsers = $code->fetchAll(PDO::FETCH_ASSOC);

            return $getUsers;
        } catch (exception $e) {
            return "Erro: {$e}";
        }
    }
}

?>