<?php
	//nome do usuário e senha do SGBD + nome do banco de dados que será usado
	$servidor = "localhost";
	$usuario = "root";
	$senha = "usbw";
	$dbname = "cronos";
	//Criar a conexao com o banco de dados
	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

	//Recuperar o valor da palavra, nesse exemplo o nome do professor
	$professor = $_POST['palavra'];
	
	//Pesquisar no banco de dados nome do professor referente a palavra digitada pelo usuário
	$professor = "SELECT * FROM professor WHERE nome LIKE '%$professor%'";
	$resultado_alunos = mysqli_query($conn, $professor);
	// Se estiver tudo certo exibe as informações
	if(mysqli_num_rows($resultado_alunos) <= 0){
		echo "Nenhum professor encontrado...";
	}else{
		while($rows = mysqli_fetch_assoc($resultado_alunos)){
			

echo '<tbody>';
echo '<tr>';
echo '<td>'.$rows['nome'].'</td>';
echo '<td>'.$rows['sobrenome'].'</td>';
echo '<td>'.$rows['email'].'</td>';
echo '<td>'.$rows['sexo'].'</td>';
echo '<td>'.$rows['disciplina'].'</td>';
echo '<td>'.$rows['rg'].'</td>';
echo '<td>'.$rows['cpf'].'</td>';
echo '<td><button> <span class="fa fa-user-circle-o"></span></button> <button><span class="fa fa-pencil"></span></button> <button><span class="fa fa-times"></span></button></td>';
        

		}
	}
	
?>