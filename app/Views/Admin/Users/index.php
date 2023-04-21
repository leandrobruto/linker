<?= $this->extend('Admin//layout/principal'); ?>

<?= $this->section('title'); ?>

  <?= $title ?>

<?= $this->endSection(); ?>

<?= $this->section('styles'); ?>

  <!-- Aqui enviamos para o layout principal os estilos -->

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

  <!-- Hoverable Table rows -->
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="table-responsive-sm text-nowrap">
            <table class="table table-hover">
            <thead>
                <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Username</th>
                <th>Tipo</th>
                <th>Ativo</th>
                <th>Ações</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php foreach ($users as $user): ?>
                <tr>
                <td>
                    <a href="<?php echo site_url("admin/users/show/$user->id"); ?>">
                        <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo ucfirst($user->name); ?></strong>
                    </a>
                </td>
                <td><?php echo $user->email; ?></td>
                <td>#<?php echo $user->username; ?></td>
                <td><?php echo $user->is_admin ? 'Administrador' : 'Cliente'; ?></td>
                <td><span class="badge <?php echo $user->active ? 'bg-primary' : 'bg-dark'; ?> me-1"><?php echo $user->active ? 'Sim' : 'Não'; ?></span></td>
                <td>
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0);"
                        ><i class="bx bx-edit-alt me-1"></i> Edit</a
                        >
                        <a class="dropdown-item" href="javascript:void(0);"
                        ><i class="bx bx-trash me-1"></i> Delete</a
                        >
                    </div>
                    </div>
                </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>
    <!--/ Hoverable Table rows -->

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

  <!-- Aqui enviamos para o layout principal os scripts -->

<?= $this->endSection(); ?>