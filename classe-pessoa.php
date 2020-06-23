<?php

  Class Pessoa{
     
     //esta classe vai possuir 6 metodos

   private $pdo;


  	public function __construct($dbname,$host,$user,$senha)

  	{
       try {

             $this -> pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
       	
       } catch (PDOException $e) {

             echo"ERRO BANCO DE DADOS : ".$e -> getMessage();
             exit();
       	
       }

       catch (Exception $e) {

       	      echo"ERRO GENERICO :".$e -> getMessage();

       	
       }


   
  	}

    //FUNÇAO PRA BUSCAR OS DADOS E POR NA TABELA

  	public function buscarDados()
  	{

      $res =array();

  		$cmd =$this->pdo->query("SELECT * FROM pessoa ORDER BY id DESC");

  		$res = $cmd -> fetchAll(PDO::FETCH_ASSOC);

  		return $res;
  	}






   //FUNÇAO PRA CADASTRAR PESSOAS

    public function cadastrarPessoa($nome, $telefone, $email)
    {
       //ANTES DE CADASTRAR VERIFICAR SE JA EXISTE UM AMIL CADASTRADO

      $cmd = $this -> pdo -> prepare("SELECT id FROM pessoa WHERE email = :e");

      $cmd->bindValue(":e",$email);

      $cmd->execute();

      if ($cmd->rowCount() >0)// se a busca retornar 1 ou seja maior que 0 significa que o email ja existe no banco
       {

        return false;
       
      }

      else// seo amil nao foi cadastrado o id nao existe entao seguinmos pra inserir

      {

        $cmd = $this->pdo->prepare("INSERT INTO pessoa (nome,telefone,email) VALUES(:n, :t, :e)");

        $cmd -> bindValue(":n",$nome);
        $cmd -> bindValue(":t",$telefone);
        $cmd -> bindValue(":e",$email);

        $cmd->execute();

        return true; 

      }

    }

    //funçao pra excluir

     public function excluirPessoa($id)
     {
        $cmd = $this-> pdo -> prepare("DELETE FROM pessoa WHERE id= :id");

        $cmd ->bindValue(":id",$id);
        $cmd ->execute();

     }



     //buscar os dados de uma pessoa especifica

     public function buscarDadosPessoa($id)
     
     {

      $res = array();

      $cmd = $this ->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");

      $cmd->bindValue(":id",$id);

      $cmd->execute();

      $res = $cmd->fetch(PDO::FETCH_ASSOC); 

      return $res;



     }


     //atualizar os dados



     public function atualizarDados($id,$nome,$telefone,$email)
     {

    




          $cmd = $this-> pdo -> prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");

          $cmd -> bindValue(":n",$nome);

          $cmd -> bindValue(":t",$telefone);

          $cmd -> bindValue(":e",$email);

          $cmd -> bindValue(":id",$id);

          $cmd -> execute();

          


       
    }

    }
 

?>