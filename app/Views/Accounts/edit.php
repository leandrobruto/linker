<?php echo $this->extend('Admin/layout/principal'); ?>

<!-- Aqui enviamos para o template principal o título -->
<?php echo $this->section('title'); ?>

  <?php echo $title; ?>

<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os estilos -->
<?php echo $this->section('styles'); ?>



<?php echo $this->endSection(); ?>



<!-- Aqui enviamos para o template principal o conteúdo -->
<?php echo $this->section('content'); ?>

  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
          <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pages-account-settings-notifications.html"
            ><i class="bx bx-bell me-1"></i> Notifications</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pages-account-settings-connections.html"
            ><i class="bx bx-link-alt me-1"></i> Connections</a
          >
        </li>
      </ul>
      <div class="card mb-4">
        <h5 class="card-header">Profile Details</h5>
        <!-- Account -->
        <div class="card-body">
          <div class="d-flex align-items-start align-items-sm-center gap-4">
            <img
              src="<?= site_url('admin/') ?>assets/img/avatars/avatar.jpg"
              alt="user-avatar"
              class="d-block rounded"
              height="100"
              width="100"
              id="uploadedAvatar"
            />
            <div class="button-wrapper">
              <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                <span class="d-none d-sm-block">Alterar foto</span>
                <i class="bx bx-upload d-block d-sm-none"></i>
                <input
                  type="file"
                  id="upload"
                  class="account-file-input"
                  hidden
                  accept="image/png, image/jpeg"
                />
              </label>
              <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                <i class="bx bx-reset d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Reset</span>
              </button>

              <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
            </div>
          </div>
        </div>
        <hr class="my-0" />
        <div class="card-body">
          <?php echo form_open("accounts/update/$user->id"); ?>
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="name" class="form-label">Name</label>
                <input
                  class="form-control"
                  type="text"
                  id="name"
                  name="name"
                  value="<?php echo ucfirst($user->name); ?>"
                  autofocus
                />
              </div>
              <div class="mb-3 col-md-6">
                <label for="username" class="form-label">Username</label>
                <input class="form-control" type="text" name="username" id="username" value="<?php echo $user->username; ?>" />
              </div>
              <div class="mb-3 col-md-6">
                <label for="website" class="form-label">Website</label>
                <input class="form-control" type="text" name="website" id="website" value="site.com.br" />
              </div>
              <div class="mb-3 col-md-6">
                <label for="bio" class="form-label">Bio</label>
                <input class="form-control" type="text" name="bio" id="bio" value="般若 👹" />
              </div>
              <div class="mb-3 col-md-6">
                <label for="email" class="form-label">E-mail</label>
                <input
                  class="form-control"
                  type="text"
                  id="email"
                  name="email"
                  value="<?php echo $user->email; ?>"
                  placeholder="<?php echo $user->email; ?>"
                />
              </div>
              <div class="mb-3 col-md-6">
                <label for="active" class="form-label">Ativo</label>
                <input
                  type="text"
                  class="form-control"
                  id="active"
                  name="active"
                  value="<?php echo ($user->active ? 'Sim' : 'Não'); ?>"
                />
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label" for="phoneNumber">Telefone</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text"></span>
                  <input
                    type="text"
                    id="phoneNumber"
                    name="phoneNumber"
                    class="form-control sp_celphones"
                    placeholder="(00) 00000-0000"
                  />
                </div>
              </div>
            </div>
            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2">Salvar alterações</button>
              <button type="reset" class="btn btn-outline-secondary me-2">Cancelar</button>
              <button type="button" class="btn btn-outline-secondary" onclick="history.back();">Voltar</button>
            </div>
          <?php echo form_close(); ?>
        </div>
        <!-- /Account -->
      </div>
      <div class="card">
        <h5 class="card-header">Excluír conta</h5>
        <div class="card-body">
          <div class="mb-3 col-12 mb-0">
            <div class="alert alert-warning">
              <h6 class="alert-heading fw-bold mb-1">Tem certeza de que deseja excluir sua conta?/h6>
              <p class="mb-0">Depois de excluir sua conta, não há como voltar atrás. Por favor, tenha certeza.</p>
            </div>
          </div>
          <form id="formAccountDeactivation" onsubmit="return false">
            <div class="form-check mb-3">
              <input
                class="form-check-input"
                type="checkbox"
                name="accountActivation"
                id="accountActivation"
              />
              <label class="form-check-label" for="accountActivation"
                >Eu confirmo a desativação da minha conta</label
              >
            </div>
            <button type="submit" class="btn btn-danger deactivate-account">Desativar conta</button>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php echo $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os scripts -->
<?php echo $this->section('scripts'); ?>

  <script src="<?php echo site_url('admin/assets/vendor/mask/jquery.mask.min.js'); ?>"></script>
  <script src="<?php echo site_url('admin/assets/vendor/mask/app.js'); ?>"></script>

<?php echo $this->endSection(); ?>