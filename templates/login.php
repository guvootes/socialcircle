
<form id="loginform" class="form-horizontal" method="post">
	<legend>Login</legend>
	<ul class="formlist">
		<li class='control-group'>
			<label class="control-label" for="email">Email</label>
			<div class="controls">
				<input type="email" name="email" id="email" />
			</div>
		</li>
		<li class='control-group'>
			<label class="control-label" for="password">Password</label>
			<div class="controls">
				<input type="password" name="password" id="password" />
			</div>
		</li>
		<li class="control-group">
			<div class="controls">
				<a href="#">Wachtwoord vergeten?</a>
			</div>
		</li>
		<li class="control-group">
		    <div class="controls">
		    	<input type="hidden" name="csrf_field" />
		    	<button type="submit" value="Submit" class='btn btn-primary'>Login</button>
		    	<a href="./#/registreer" class="btn" id="register">Registreer</a>
		    </div>
		</li>
		
	</ul>
</form>
