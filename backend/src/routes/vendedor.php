<?php

    $app->get('/vendedor', function ($request, $response, $args) {

        $resultado = new stdClass();

		$sql = "Select * From vendedor";
		$sth = $this->db->prepare($sql);
		try {
			$sth->execute();
		} catch (Exception $e) {
			$resultado->retorno = "ERRO";
			$resultado->detalhes = $e->getMessage();
			return $response->withJson($resultado);
        }
        
        $array = [];
        
		while($dados = $sth->fetch(PDO::FETCH_OBJ)) {

			$sql = "Select COALESCE(ROUND(SUM(VALOR * 0.085), 2), 0) as COMISSAO From venda Where ID_VENDEDOR = :id";
			$sth2 = $this->db->prepare($sql);
			try {
				$sth2->bindParam("id", $dados->ID);
				$sth2->execute();
			} catch (Exception $e) {
				$resultado->retorno = "ERRO";
				$resultado->detalhes = $e->getMessage();
				return $response->withJson($resultado);
            }
            
			$dados->COMISSAO = ($sth2->fetch(PDO::FETCH_OBJ))->COMISSAO;
			$array[] = $dados;
		}
		
		$resultado->detalhes = $array;
		$resultado->retorno = "OK";
		return $response->withJson($resultado);
    });

    $app->post('/vendedor', function($request, $response, $args){

		$body = $request->getParsedBody();
        $resultado = new stdClass();

		$sql = "Insert into vendedor (NOME, EMAIL) Values (:nome, :email)";
        $sth = $this->db->prepare($sql);

		try {
			$sth->bindParam("nome", $body["nome"]);
			$sth->bindParam("email", $body["email"]);
			$sth->execute();
		} catch (PDOException $e) {
			$resultado->retorno = "ERRO";
			$resultado->detalhes = $e->getMessage();
			return $response->withJson($resultado);
		}

		$saida = new stdClass();
		$saida->id = $this->db->lastInsertId();
		$saida->nome = $body["nome"];
		$saida->email = $body["email"];
		
		$resultado->detalhes = $saida;
		$resultado->retorno = "OK";
        return $response->withJson($resultado);
        
    });