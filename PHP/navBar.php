<header class="container-fluid ">
	<div class="row">
		<div class="col-sm-6"><a href="index.php"><img src="../images/logo.png" alt="logomarca MBImobiliaria" style="width: 200px; padding: 8px"></a></div>
	</div>
</header>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark menu">
	<div class="container-fluid">
		<ul class="navbar-nav mr-auto">
			<li <?php if ($paginaAtiva == 'index') echo "class='nav-item active'";?>>
        		<a class="nav-link" href="index.php">Home</a>
			</li>
			<li <?php if ($paginaAtiva == 'galeria') echo "class='nav-item active'";?>>
        		<a class="nav-link" href="galeria.php">Galeria</a>
			</li>
			<li <?php if ($paginaAtiva == 'contato') echo "class='nav-item active'";?>>
        		<a class="nav-link" href="contato.php">Contato</a>
			</li>
			<li <?php if ($paginaAtiva == 'pesquisaImovel') echo "class='nav-item active'";?>>
        		<a class="nav-link" href="pesquisaImovel.php">Encontre Seu Imóvel</a>
     		</li>
		</ul>
		<ul class="nav navbar-nav navbar-right menu">
			<li ><a class="nav-link" data-toggle="modal" data-target="#formLoginModal" href="">Login</a></li>
		</ul>
	</div>
</nav>

<!--Modal de Login-->
<div class="modal faden" id="formLoginModal" tabindex="-1" aria-labelledby="formLoginModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h2>MB Imobiliaria - Acesso restrito</h2>	
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>				
			</div>
			<div class="modal-body">
				<div class="form-group"><br>
					<label>Login:</label>
					<input type="text" required autofocus name="usuario" id="usuario" class="form-control" placeholder="Digite seu usuário... " />
				</div>
				<div class="form-group">
					<label>Senha:</label>
					<input type="password" required name="password" id="password" class="form-control" placeholder="Digite sua senha... " />
				</div>
				<div class="btn-group">
					<button type="button" name="login_button" id="login_button" class="btn btn-primary">Login</button>
				</div>							
			</div>
			<div class="modal-footer">
				<p class="text-center">Mb Imobiliária</p>
			</div>
		</div>
	</div>		
</div>