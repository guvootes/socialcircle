<h1>Login</h1>
<form id="loginform" method="post">
	<ul class="formlist">
		<li>
			<label for="email">Email</label>
			<input type="email" name="email" id="email" />
		</li>
		<li>
			<label for="password">Password</label>
			<input type="password" name="password" id="password" />
		</li>
	</ul>
	<input type="hidden" name="csrf_field" />
	<button type="submit" value="Submit">Login</button>
</form>

<a href="/#/registreer">registreer</a>