<?= $this->extend('Admin//layout/principal'); ?>

<?= $this->section('title'); ?>

  <?= $title ?>

<?= $this->endSection(); ?>

<?= $this->section('styles'); ?>



<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

  
  <div class="row">
  <?php foreach ($connections as $user): ?>
    <div class="col-3">
      <div class="card mb-4">
        <div class="d-flex flex-column text-sm-start mb-4">
          <div class="flex-shrink-0 mt-n2 mx-sm-4 mx-auto">
            <img src="<?= site_url('admin/') ?>assets/img/avatars/avatar.jpg" alt="User image" class="w-px-150 d-block h-auto ms-0 ms-sm-4 rounded-circle">
          </div>
          <div class="flex-grow-1 mt-3">
            <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
              <div class="">
                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                  <div class="col-12 text-center">  
                    <li class="list-inline-item fw-semibold">
                      <h5 class="mb-0"><?php echo esc(ucfirst($user->name)); ?></h5>
                    </li>
                  </div>
                  <div class="col-12 text-center">
                    <li class="list-inline-item fw-semibold">                  
                      <small class="">#<?php echo esc($user->username); ?></small>
                    </li>
                  </div>
                  <div class="col-12 text-center">
                    <li class="list-inline-item fw-semibold">
                      <a href="<?php echo site_url('accounts/') . $user->username; ?>" class="btn rounded-pill btn-sm btn-primary text-nowrap">
                        <i class='bx bx-user me-1'></i> Ver Perfil
                      </a>
                    </li>
                  </div>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
 
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>



<?= $this->endSection(); ?>