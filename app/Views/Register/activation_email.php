<h1><?php echo esc($user->name); ?>, agora falta muito pouco!</h1>

<p>Clique no link abaixo para ativar a sua conta e aproveitar as delícias que a Food Delivery tem para oferecer.</p>

<p>
    <a href="<?php echo site_url('register/activate/' . $user->token) ?>">Ativar minha conta.</a>
</p>