<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $app->post('/email', function($request, $response, $args){

        $body = $request->getParsedBody();
        $resultado = new stdClass();

        $sql = "SELECT COALESCE(SUM(VALOR), 0) as VALOR FROM venda WHERE DATA = DATE(NOW())";
        $sth = $this->db->prepare($sql);
        try {
            $sth->execute();
        } catch (Exception $e) {
            $resultado->retorno = "ERRO";
            $resultado->detalhes = $e->getMessage();
            return $response->withJson($resultado);
        }
        $dados = $sth->fetch(PDO::FETCH_OBJ);
        $valortotal = $dados->VALOR;

        $data = date('d/m/Y');

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            $mail->setLanguage('pt-br', '/optional/path/to/language/directory/');

            //Server settings
            // $mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com';  						// Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $body['emailauth'];                     // SMTP username
            $mail->Password   = $body['senhaauth'];                     // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($body['emailauth']);
            $mail->addAddress($body['emailenviar']);     				// Add a recipient

            // Content
            $mail->Subject = 'Relatorio de Vendas';
            $mail->Body    = $data.' - Valor total de vendas realizadas: '.$valortotal;

            $mail->send();
        } catch (Exception $e) {
            $resultado->retorno = "ERRO";
            $resultado->detalhes = $mail->ErrorInfo;
            return $response->withJson($resultado);
        }

        $resultado->retorno = "OK";
        return $response->withJson($resultado);
        
    });

?>