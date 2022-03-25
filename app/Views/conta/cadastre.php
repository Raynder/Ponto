<?php

	if(isset($dados) && !empty($dados)){
		$status = $dados['status'];
		$msg = $dados['msg'];
	}
	else{
		$status = '';
		$msg = '';
	}
?>

<link rel="icon" type="image/png" href="https://colorlib.com/etc/lf/Login_v2/images/icons/favicon.ico">

<link rel="stylesheet" type="text/css" href="<?=DIST?>loginPag/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="<?=DIST?>loginPag/material-design-iconic-font.min.css">

<link rel="stylesheet" type="text/css" href="<?=DIST?>loginPag/animate.css">

<link rel="stylesheet" type="text/css" href="<?=DIST?>loginPag/hamburgers.min.css">

<link rel="stylesheet" type="text/css" href="<?=DIST?>loginPag/animsition.min.css">

<link rel="stylesheet" type="text/css" href="<?=DIST?>loginPag/select2.min.css">

<link rel="stylesheet" type="text/css" href="<?=DIST?>loginPag/daterangepicker.css">

<link rel="stylesheet" type="text/css" href="<?=DIST?>loginPag/util.css">
<link rel="stylesheet" type="text/css" href="<?=DIST?>loginPag/main.css">

<meta name="robots" content="noindex, follow">
<script type="text/javascript" async="" src="<?=DIST?>loginPag/analytics.js"></script><script defer="" src="<?=DIST?>loginPag/s.js"></script><script>(function(w,d){!function(e,t,r,a,s){e[r]=e[r]||{},e[r].executed=[],e.zaraz={deferred:[]};var n=t.getElementsByTagName("title")[0];e[r].c=t.cookie,n&&(e[r].t=t.getElementsByTagName("title")[0].text),e[r].w=e.screen.width,e[r].h=e.screen.height,e[r].j=e.innerHeight,e[r].e=e.innerWidth,e[r].l=e.location.href,e[r].r=t.referrer,e[r].k=e.screen.colorDepth,e[r].n=t.characterSet,e[r].o=(new Date).getTimezoneOffset(),//
e[s]=e[s]||[],e.zaraz._preTrack=[],e.zaraz.track=(t,r)=>e.zaraz._preTrack.push([t,r]),e[s].push({"zaraz.start":(new Date).getTime()});var i=t.getElementsByTagName(a)[0],o=t.createElement(a);o.defer=!0,o.src="/cdn-cgi/zaraz/s.js?"+new URLSearchParams(e[r]).toString(),i.parentNode.insertBefore(o,i)}(w,d,"zarazData","script","dataLayer");})(window,document);</script></head>

<div class="limiter">
<div class="container-login100">
<div class="wrap-login100">
	<?php
		if($status == 'erro'){
			echo '<div class="alert alert-danger">'.$msg.'</div>';
		}
		else if($status == 'sucesso'){
			echo '<div class="alert alert-success">'.$msg.'</div>';
			echo("<script>setTimeout(function(){window.location.href = '".URL."conta';}, 2000);</script>");
		}
	?>
<form method="POST" class="login100-form validate-form">
<span class="login100-form-title p-b-26">
<?=APP_NOME?> CLIENTE
</span>
<span class="login100-form-title p-b-48">
<i class="zmdi zmdi-font"></i>
</span>

<div class="wrap-input100 validate-input" data-validate="Digite seu nome">
<input class="input100" type="text" name="nome">
<span class="focus-input100" data-placeholder="Nome"></span>
</div>

<div class="wrap-input100 validate-input" data-validate="Email invalido">
<input class="input100" type="text" name="email">
<span class="focus-input100" data-placeholder="Email"></span>
</div>

<div class="wrap-input100 validate-input" data-validate="CNPJ invalido">
<input class="input100" type="text" name="cnpj">
<span class="focus-input100" data-placeholder="CNPJ"></span>
</div>

<div class="wrap-input100 validate-input" data-validate="Defina uma senha">
<span class="btn-show-pass">
<i class="zmdi zmdi-eye"></i>
</span>
<input class="input100" type="password" name="senha">
<span class="focus-input100" data-placeholder="Senha"></span>
</div>

<div class="wrap-input100 validate-input" data-validate="Repita sua senha">
<span class="btn-show-pass">
<i class="zmdi zmdi-eye"></i>
</span>
<input class="input100" type="password" name="confirmarSenha">
<span class="focus-input100" data-placeholder="Repita sua senha"></span>
</div>

<div class="container-login100-form-btn">
<div class="wrap-login100-form-btn">
<div class="login100-form-bgbtn"></div>
<button class="login100-form-btn">
Login
</button>
</div>
</div>
<div class="text-center p-t-115">
<span class="txt1">
Já tem uma conta?
</span>
<a class="txt2" href="../conta">
Entrar
</a>
</div>
</form>
</div>
</div>
</div>
<div id="dropDownSelect1"></div>

<script src="<?=DIST?>loginPag/jquery-3.2.1.min.js"></script>

<script src="<?=DIST?>loginPag/animsition.min.js"></script>

<script src="<?=DIST?>loginPag/popper.js"></script>
<script src="<?=DIST?>loginPag/bootstrap.min.js"></script>

<script src="<?=DIST?>loginPag/select2.min.js"></script>

<script src="<?=DIST?>loginPag/moment.min.js"></script>
<script src="<?=DIST?>loginPag/daterangepicker.js"></script>

<script src="<?=DIST?>loginPag/countdowntime.js"></script>

<script src="<?=DIST?>loginPag/main.js"></script>

<script async="" src="<?=DIST?>loginPag/js"></script>
<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-23581568-13');
	</script>
<script defer="" src="<?=DIST?>loginPag/v64f9daad31f64f81be21cbef6184a5e31634941392597" integrity="sha512-gV/bogrUTVP2N3IzTDKzgP0Js1gg4fbwtYB6ftgLbKQu/V8yH2+lrKCfKHelh4SO3DPzKj4/glTO+tNJGDnb0A==" data-cf-beacon="{&quot;rayId&quot;:&quot;6bb145878563cff0&quot;,&quot;token&quot;:&quot;cd0b4b3a733644fc843ef0b185f98241&quot;,&quot;version&quot;:&quot;2021.11.0&quot;,&quot;si&quot;:100}" crossorigin="anonymous"></script>
<script defer="" src="<?=DIST?>loginPag/v64f9daad31f64f81be21cbef6184a5e31634941392597" integrity="sha512-gV/bogrUTVP2N3IzTDKzgP0Js1gg4fbwtYB6ftgLbKQu/V8yH2+lrKCfKHelh4SO3DPzKj4/glTO+tNJGDnb0A==" data-cf-beacon="{&quot;rayId&quot;:&quot;6bb145876bc1cff0&quot;,&quot;token&quot;:&quot;cd0b4b3a733644fc843ef0b185f98241&quot;,&quot;version&quot;:&quot;2021.11.0&quot;,&quot;si&quot;:100}" crossorigin="anonymous"></script>
