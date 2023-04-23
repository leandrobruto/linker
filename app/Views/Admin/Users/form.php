<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input 
    type="text" 
    class="form-control" 
    id="email" 
    name="email" 
    value="<?php echo old('email'); ?>" 
    placeholder="Digite o email"
    autofocus />
</div>  
<div class="mb-3">
    <label for="name" class="form-label">Nome</label>
    <input
    type="text"
    class="form-control"
    id="name"
    name="name"
    value="<?php echo old('name'); ?>"
    placeholder="Digite o nome completo"
    />
</div>
<div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input
    type="text"
    class="form-control"
    id="username"
    name="username"
    value="<?php echo old('username'); ?>"
    placeholder="Digite o nome de usuário"
    />
</div>
<div class="mb-3 form-password-toggle">
    <label class="form-label" for="password">Senha</label>
    <div class="input-group input-group-merge">
        <input
        type="password"
        id="password"
        class="form-control"
        name="password"
        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
        aria-describedby="password"
        />
        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
    </div>
</div>
<div class="mb-3 form-password-toggle">
    <label class="form-label" for="password_confirmation">Confirmar senha</label>
    <div class="input-group input-group-merge">
        <input
        type="password"
        id="password_confirmation"
        class="form-control"
        name="password_confirmation"
        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
        aria-describedby="password"
        />
        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
    </div>
</div>

<div class="row gy-3 mt-3 mb-3">
<div class="col-md">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="is_admin" value="1" id="is_admin" >
        <label class="form-label form-check-label" for="admin"> Admin </label>
        </div></div>
    <div class="col-md">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="active" value="1" id="active" >
        <label class="form-label form-check-label" for="active"> Ativo </label>
    </div></div>
</div>

<div class="row">
    <div class="col-6 text-center">
        <button type="submit" class="btn rounded-pill btn-primary">
            <span class="tf-icons bx bx-user-plus"></span> Cadastrar
        </button>
    </div>
    <div class="col-6 text-center">
        <button type="button" onclick="history.back()" class="btn rounded-pill btn-secondary">
            <span class="tf-icons bx bx-arrow-back"></span> Voltar
        </button>
    </div>
</div>
