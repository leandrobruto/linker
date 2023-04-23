<?= $this->extend('Admin/layout/principal'); ?>

<?= $this->section('title'); ?>

  <?= $title ?>

<?= $this->endSection(); ?>

<?= $this->section('styles'); ?>

<link rel="stylesheet" href="<?php echo site_url('admin/assets/vendor/auto-complete/jquery-ui.css'); ?>"/>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

  <!-- Hoverable Table rows -->
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="<?php echo site_url('admin/users/create'); ?>" class="btn rounded-pill btn-sm btn-primary text-nowrap float-end">
                <i class='bx bx-plus me-1'></i> Cadastrar
            </a>
        </div>
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

<script src="<?php echo site_url('admin/assets/vendor/auto-complete/jquery-ui.js'); ?>"></script>


<script>

    $(function () {

        $("#query").autocomplete({

            source: function (request, response) {

                $.ajax({

                    url: "<?php echo site_url('admin/users/search'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {

                        if (data.length < 1) {

                            var data = [
                                {
                                    label: 'Usuario não encontrado',
                                    value: -1
                                }
                            ];

                        }
                        response(data); // Aqui temos valor no data

                    },

                }); // fim ajax

            },
            minLenght: 1,
            select: function (event, ui) {

                if (ui.item.value == -1) {

                    $(this).val("");
                    return false;

                } else {

                    window.location.href = '<?php echo site_url('admin/users/show/'); ?>' + ui.item.id;
                }

            }

        }); // fim autocomplete

    });

</script>

<?= $this->endSection(); ?>