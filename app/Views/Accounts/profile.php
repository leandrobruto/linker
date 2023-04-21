<?= $this->extend('Admin//layout/principal'); ?>

<?= $this->section('title'); ?>

  <?= $title ?>

<?= $this->endSection(); ?>

<?= $this->section('styles'); ?>



<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
          <div class="flex-shrink-0 mt-n2 mx-sm-4 mx-auto">
            <img src="<?= site_url('admin/') ?>assets/img/avatars/avatar.jpg" alt="User image" class="w-px-150 d-block h-auto ms-0 ms-sm-4 rounded-circle">
          </div>
          <div class="flex-grow-1 mt-3 mt-sm-5">
            <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
              <div class="">
                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                  <li class="list-inline-item fw-semibold">
                    <h4 class="mb-0"><?php echo esc(ucfirst($user->name)); ?></h4>
                  </li>
                  <?php if (userLoggedIn() and userLoggedIn()->id === $user->id): ?>
                    <li>
                      <a href="<?php echo site_url('accounts/edit/') . $user->username; ?>" class="btn rounded-pill btn-sm btn-primary text-nowrap">
                        <i class='bx bx-pencil me-1'></i>Editar Perfil
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo site_url('accounts/edit/') . $user->username; ?>" class="btn rounded-pill btn-sm btn-secondary text-nowrap">
                        <i class='bx bx-user me-1'></i>Convidar amigo
                      </a>
                    </li>
                  <?php else: ?>
                    <li>
                      <?php echo form_open("accounts/connect/". userLoggedIn()->id); ?>
                        <input type="hidden" name="requester_user_id" value="<?= userLoggedIn()->id ?>">
                        <input type="hidden" name="requested_user_id" value="<?= $user->id ?>">
                        
                        <button type="submit" class="btn btn-sm rounded-pill btn-primary">
                          <span class="tf-icons bx bx-user-plus"></span> Conectar
                        </button>
                      <?php echo form_close(); ?>
                    </li>
                    <li>
                      <a href="<?php echo site_url('accounts/edit/') . $user->username; ?>" class="btn rounded-pill btn-sm btn-secondary text-nowrap">
                        <i class='bx bx-lock me-1'></i>Enviar mensagem
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo site_url('accounts/edit/') . $user->username; ?>" title="Seguir" class="btn rounded-pill btn-sm btn-icon btn-primary">
                        <span class="bx bx-plus"></span>
                      </a>
                    </li>
                  <?php endif; ?>
                </ul>
                <small class="">#<?php echo esc($user->username); ?></small>
                <p>Bora Bio 般若 👹</p>
                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                <a href="javascript:void(0)" class="">
                  <li class="list-inline-item">
                    <i class="bx bx-link"></i> 666 Conexões
                  </li>
                  </a>
                  <li class="list-inline-item">
                    <i class="bx bx-calendar-alt"></i> <?php echo esc($user->created_at->humanize()) ?>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>



<?= $this->endSection(); ?>