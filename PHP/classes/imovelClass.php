<?php

	

class Imovel_class{
	private $pdo;

	public function __construct($dbname,$host,$user,$senha)
	{
		try{
			$this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
		}catch(PDOException $e){
			echo 'Erro no banco' . $e->getMessage();
		}
		catch(Exception $e){
			echo 'Erro geral' .$e->getMessage();
		}
	}

	public function enviarImovel($tipoImovel,$codProprietario,$categoriaImovel,$valor,$bairro,$qtdQuartos,$qtdSuites,$descricao,$areaQuadrada,$piscina,$numeroApartamento,$andar,
	$valorCondominio,$fotos = array()){
		
		//Insere Imóvel
		
		$cmd = $this->pdo->prepare('INSERT INTO Imoveis(tipoImovel,codProprietario,categoriaImovel,valor,bairro,qtdQuartos,qtdSuites,descricao,areaQuadrada,piscina,numeroApartamento,andar,
		valorCondominio) VALUES (:a,:b,:c,:d,:e,:f,:g,:h,:i,:j,:k,:l,:m);');

		$cmd->bindValue(':a',$tipoImovel);
		$cmd->bindValue(':b',$codProprietario);
		$cmd->bindValue(':c',$categoriaImovel);
		$cmd->bindValue(':d',$valor);
		$cmd->bindValue(':e',$bairro);
		$cmd->bindValue(':f',$qtdQuartos);
		$cmd->bindValue(':g',$qtdSuites);
		$cmd->bindValue(':h',$descricao);
		$cmd->bindValue(':i',$areaQuadrada);
		$cmd->bindValue(':j',$piscina);
		$cmd->bindValue(':k',$numeroApartamento);
		$cmd->bindValue(':l',$andar);
		$cmd->bindValue(':m',$valorCondominio);

		if($cmd->execute()){
	   }else{
		   echo("Error ao adicionar novo registro: ");
		   print_r($cmd->errorInfo());
		   var_dump($_POST['piscina']);

	   }
		$id_imovel = $this->pdo->LastInsertId();

		if(count($fotos) > 0){
			for($i=0; $i < count($fotos); $i++){
				$nome_imagem = $fotos[$i];
				//Insere as imagens
				$cmd = $this->pdo->prepare('INSERT INTO Imagens (nome_imagem,fk_id_imovel) VALUES (:n,:fk)');
				$cmd->bindValue(':n',$nome_imagem);
				$cmd->bindValue(':fk',$id_imovel);
				$cmd->execute();
			}
		}
	}

	
	
	public function buscarImoveis($categoriaImovel,$bairro,$valorMinimo,$valorMaximo,$descricao){
		$cmd = $this->pdo->prepare('SELECT *,
		(SELECT nome_imagem FROM Imagens WHERE fk_id_imovel = Imoveis.id LIMIT 1)
		 AS foto_capa FROM Imoveis WHERE categoriaImovel like :a and bairro like :b and
		valor between :c and :d and descricao like :e');
		$cmd->bindValue(':a',"%".$categoriaImovel."%");
		$cmd->bindValue(':b',"%".$bairro."%");
		$cmd->bindValue(':c',$valorMinimo);
		$cmd->bindValue(':d',$valorMaximo);
		$cmd->bindValue(':e',"%".$descricao."%");
	
		$cmd->execute();

		if($cmd->rowCount() > 0){
			$dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
		}else{
			$dados = array();
		}

		return $dados;

	}

	public function buscarImoveisId($id){
		$cmd = $this->pdo->prepare('SELECT * FROM Imoveis
		WHERE id = :id');
		$cmd->bindValue(':id',$id);
		$cmd->execute();
		if($cmd->rowCount() > 0){
			$dados = $cmd->fetch(PDO::FETCH_ASSOC);
		}else{
			$dados = array();
		}

		return $dados;
	}

	public function buscarClientes(){
		$cmd = $this->pdo->prepare('SELECT id,nome FROM Clientes
		WHERE statusCliente = :id');
		$cmd->bindValue(':id',"A"); 
		$cmd->execute();
		if($cmd->rowCount() > 0){
			$dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
		}else{
			$dados = array();
		}
		return $dados;
	}

	public function buscarBairros(){
		$cmd = $this->pdo->prepare('SELECT bairro FROM Imoveis');

		$cmd->execute();
		if($cmd->rowCount() > 0){
			$dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
		}else{
			$dados = array();
		}
		return $dados;
	}

	public function pesquisarImoveis(){
		$cmd = $this->pdo->prepare('SELECT id,nome FROM Clientes
		WHERE statusCliente = :id');
		$cmd->bindValue(':id',"A"); 
		$cmd->execute();
		if($cmd->rowCount() > 0){
			$dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
		}else{
			$dados = array();
		}
		return $dados;
	}

	public function buscarImagensPorId($id){
	
	$cmd = $this->pdo->prepare('SELECT * FROM Imagens
		WHERE fk_id_imovel = :id');
		$cmd->bindValue(':id',$id);
		$cmd->execute();
		if($cmd->rowCount() > 0){
			$dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
		}else{
			$dados = array();
		}

		return $dados;
	}

}
?>
