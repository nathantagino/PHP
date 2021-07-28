
<!DOCTYPE html>
<html lang=”pt-br”>

<head>
  <title>Cronos</title>
</head>

<body>

<?php
// Conexão com o banco de dados
$conn = @mysql_connect("localhost","root", "usbw") or die ("Problemas na conexão.");
$db = @mysql_select_db("cronos", $conn) or die ("Problemas na conexão");

// Se o usuário clicou no botão cadastrar efetua as ações
if (isset($_POST['cadastrar'])) {
	
	// Recupera os dados dos campos
	$nome = $_POST['nome'];
	$sobrenome = $_POST['sobrenome'];
	$idade = $_POST['idade'];
	$senha= $_POST['senha'];
	$email = $_POST['email'];
	$cpf = $_POST['cpf'];
	$rg = $_POST['rg'];
	$sexo = $_POST['sexo'];
	$foto = $_FILES["foto"];
	$periodo = $_POST['periodo'];
	$turma = $_POST['turma'];
	$instituicao = $_POST['instituicao'];
	
	// Se a foto estiver sido selecionada
	if (!empty($foto["name"])) {
		
		// Largura máxima em pixels
		$largura = 15000;
		// Altura máxima em pixels
		$altura = 180000;
		// Tamanho máximo do arquivo em bytes
		$tamanho = 1000000;

		$error = array();

    	// Verifica se o arquivo é uma imagem
    	if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){
     	   $error[1] = "Isso não é uma imagem.";
   	 	} 
	
		// Pega as dimensões da imagem
		$dimensoes = getimagesize($foto["tmp_name"]);
	
		// Verifica se a largura da imagem é maior que a largura permitida
		if($dimensoes[0] > $largura) {
			$error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
		}

		// Verifica se a altura da imagem é maior que a altura permitida
		if($dimensoes[1] > $altura) {
			$error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
		}
		
		// Verifica se o tamanho da imagem é maior que o tamanho permitido
		if($foto["size"] > $tamanho) {
   		 	$error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
		}

		// Se não houver nenhum erro
		if (count($error) == 0) {
		
			// Pega extensão da imagem
			preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

        	// Gera um nome único para a imagem
        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];

        	// Caminho de onde ficará a imagem
        	$caminho_imagem = "fotos/" . $nome_imagem;

			// Faz o upload da imagem para seu respectivo caminho
			move_uploaded_file($foto["tmp_name"], $caminho_imagem);
		
			// Insere os dados no banco
			$sql = mysql_query ("INSERT INTO aluno(nome,sobrenome,idade,periodo,email,senha,sexo,rg,cpf,foto,turma,instituicao)  VALUES ('".$nome."', '".$sobrenome."', '".$idade."','".$periodo."','".$email."','".$senha."','".$sexo."','".$rg."','".$cpf."','".$nome_imagem."','".$turma."','".$instituicao."')");
		
			// Se os dados forem inseridos com sucesso
			if ($sql){ ?>
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Aluno cadastrado com Sucesso!</h4>
						</div>
						<div class="modal-body">
							<div class="panel panel-primary">
            
            <div class="panel-body">
              <div class="row">
                <div class="col-md-6 col-lg-6 " align="center"> <img alt="User Pic" src="fotos/<?php echo $nome_imagem;?>" width="120" height="100" class="img-circle"> </div>
                
             
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Nome do aluno</td>
                        <td><?php echo $nome; ?></td>
                      </tr>
                      <tr>
                        <td>Sobrenome do aluno</td>
                        <td><?php echo $sobrenome; ?></td>
                      </tr>
                      <tr>
                        <td>Aniversário do aluno</td>
                        <td><?php echo $idade; ?></td>
                      </tr>
                   
                         <tr>
                             <tr>
                        <td>Sexo do aluno</td>
                        <td><?php echo $sexo; ?></td>
                      </tr>
                        <tr>
                        <td>Turma</td>
                        <td><?php echo $turma; ?></td>
                      </tr>
                      <tr>
                        <td>Email do aluno</td>
                        <td><?php echo $email; ?></td>
                      </tr>
                        
                           
                      </tr>
                     
                    </tbody>
                  </table>
                  
                
                </div>
              </div>
            </div>
                 
            
          </div>
							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-info" data-dismiss="modal">Corrigir Cadastro</button>
							<a href="cadastraralunos.php"><button type="button" class="btn btn-xs btn-primary">Ok</button></a>
						</div>
					</div>
				</div>
			</div>				
			<script>
				$(document).ready(function () {
					$('#myModal').modal('show');
				});
			</script>
			<?php }} 
		
	
		// Se houver mensagens de erro, exibe-as
		if (count($error) != 0) {
			foreach ($error as $erro) {
				echo $erro . "<br />";
			}
		}
	}
}
?>


<div>
<div>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" name="cadastro" class="form-horizontal" >

<fieldset>

<!-- Form Name -->
 <div class="alert alert-info" role="alert">
 Cadastrar Aluno
</div>

<!-- Nome input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="idNome">Nome</label>  
  <div class="col-md-5">
  <input id="idNome" name="nome" type="text" placeholder="Nome do Aluno" class="form-control input-md" required="">
    
  </div>
</div>

<!-- TSobrenome input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="idDepto">Sobrenome</label>  
  <div class="col-md-5">
  <input id="idDepto" name="sobrenome" type="text" placeholder="Sobrenome do Aluno" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Email input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="idUsuario">Email</label>  
  <div class="col-md-5">
  <input id="idUsuario" name="email" type="text" placeholder="Email do Aluno" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Idade input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="idSenha">Nascimento</label>
  <div class="col-md-5">
    <input type="date" id="party" name="idade" min="1900-04-01" max="2019-04-30" required>
    
  </div>
</div>

<!-- RG input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="idSenha">RG</label>
  <div class="col-md-5">
    <input id="idSenha" name="rg" type="text" placeholder="RG do Aluno" class="form-control input-md" required="">
    
  </div>
</div>


<!-- CPF input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="idSenha">CPF</label>
  <div class="col-md-5">
    <input id="idSenha" name="cpf" type="text" placeholder="CPF do Aluno" class="form-control input-md" required="">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="idSenha">Senha</label>
  <div class="col-md-5">
    <input id="idSenha" name="senha" type="text" placeholder="Senha do Aluno" class="form-control input-md" required="">
    
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="idAdmin">Sexo</label>
  <div class="col-md-5">
    <select id="idAdmin" name="sexo" class="form-control">
      <option value="0">Selecione</option>
     <option> Masculino 
	<option> Feminino
	<option> Indefinido 
    </select>
  </div>
</div>



<div class="form-group">
  <label class="col-md-4 control-label" for="idAdmin">Turma</label>
  <div class="col-md-5">
    <select id="idAdmin" name="turma" class="form-control">
      <option value="0">Selecione</option>
     <option> 1 ano A
	<option> 1 ano B
	<option> 2 ano A
	<option>2 ano B
	<option>3 ano A
	<option>3 ano B

    </select>
  </div>
</div>

<!-- Turma input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="idAdmin">Instituicao</label>
  <div class="col-md-5">
    <select>
      <option value="0">Selecione</option>
     <option>Etec Dr. Jose Luiz Viana Coutinho - Centro/ Corrego Tambory - Jales
	<option>Etec Abdias do Nascimento - Morumbi (Paraisopolis) - Sao Paulo
	<option>Etec Adolpho Berezin - Mongagua
	<option>Etec Albert Einstein - Casa Verde - Sao Paulo
	<option>Etec Albert Einstein - Extensao EE Emiliano Augusto C. de Albuquerque e Melo - Alto de Pinheiros - Sao Paulo
	<option>Etec Albert Einstein - Extensao EE Prof. Carlos de Laet - Mandaqui - Sao Paulo
	<option>Etec Alberto Santos Dumont - Guaruja

    </select>
  </div>
</div>



<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="idAdmin">Periodo</label>
  <div class="col-md-5">
    <select id="idAdmin" name="periodo" class="form-control">
      <option value="0">Selecione</option>
      <option> Matutino
	  <option> Vespertino
	  <option> Noturno
	  <option> Integral
    </select>
  </div>
</div>



<div class="form-group">
  <label class="col-md-4 control-label" for="idSenha">Foto de Perfil do Aluno :</label>
  <div class="col-md-5">
    <input id="idSenha" name="foto" type="file" placeholder="Turma do Aluno" class="form-control input-md" required="">
    
  </div>
</div>



<div class="form-group">
  <label class="col-md-4 control-label" for="idConfirmar"></label>
  <div class="col-md-8">
    <button type="submit" name="cadastrar" value="Cadastrar" class="btn btn-xs btn-primary">Confirmar</button>
    <button id="idCancelar" name="idCancelar" class="btn btn-danger">Cancelar</button>
  </div>
</div>

</fieldset>
</form> 

</body>

</html>
