<?php

    $app->post('/venda', function($request, $response){

		$body = $request->getParsedBody();
		$resultado = new stdClass();

		$sql = "Select * From vendedor Where ID = :id";
		$sth = $this->db->prepare($sql);
		try {
			$sth->bindParam("id", $body["id"]);
			$sth->execute();
		} catch (Exception $e) {
			$resultado->retorno = "ERRO";
			$resultado->detalhes = $e->getMessage();
			return $response->withJson($resultado);
        }
        
		if($sth->rowCount() == 0) {
			$resultado->retorno = "ATENCAO";
			$resultado->detalhes = "Vendedor informado nao existe!";
			return $response->withJson($resultado);
		}

		$sql = "Insert into venda (VALOR, DATA, ID_VENDEDOR) Values (:valor, NOW(), :id)";
		$sth = $this->db->prepare($sql);
		try {
			$sth->bindParam("valor", $body["valor"]);
			$sth->bindParam("id", $body["id"]);
			$sth->execute();
		} catch (PDOException $e) {
			$resultado->retorno = "ERRO";
			$resultado->detalhes = $e->getMessage();
			return $response->withJson($resultado);
		}

		$saida = new stdClass();
		$saida->id = $this->db->lastInsertId();

		// Busca dados do vendedor
		$sql = "Select ve.NOME, ve.EMAIL, v.VALOR, v.DATA From venda v
		Inner join vendedor ve On (ve.ID = v.ID_VENDEDOR)
		Where v.ID = :id";
		$sth = $this->db->prepare($sql);
		try {
			$sth->bindParam("id", $saida->id);
			$sth->execute();
		} catch (Exception $e) {
			$resultado->retorno = "ERRO";
			$resultado->detalhes = $e->getMessage();
			return $response->withJson($resultado);
		}
		while($dados = $sth->fetch(PDO::FETCH_OBJ)) {
			$saida->nome = $dados->NOME;
			$saida->email = $dados->EMAIL;
			$saida->comissao = round($body["valor"] * 0.085, 2);
			$saida->valor = $dados->VALOR;
			$saida->data = date('d/m/Y', strtotime($dados->DATA));
		}
		
		$resultado->retorno = "OK";
		$resultado->detalhes = $saida;
		return $response->withJson($resultado);
	});

	$app->get('/venda', function($request, $response, $args){
		$resultado = new stdClass();
		$params = $request->getQueryParams();

		$sql = "Select v.ID, ve.NOME, ve.EMAIL, COALESCE(ROUND(v.VALOR * 0.085, 2), 0) as COMISSAO, v.VALOR, DATE_FORMAT(STR_TO_DATE(v.DATA, '%Y-%m-%d'), '%d/%m/%Y') as DATA From venda v
		Left outer join vendedor ve On (ve.ID = v.ID_VENDEDOR)
		Where v.ID_VENDEDOR = :id";
		$sth = $this->db->prepare($sql);
		try {
			$sth->bindParam("id", $params["id"]);
			$sth->execute();
		} catch (Exception $e) {
			$resultado->retorno = "ERRO";
			$resultado->detalhes = $e->getMessage();
			return $response->withJson($resultado);
        }
        
		$dados = $sth->fetchAll(PDO::FETCH_OBJ);
		
		$resultado->detalhes = $dados;
		$resultado->retorno = "OK";
		return $response->withJson($resultado);
    });
    
?>