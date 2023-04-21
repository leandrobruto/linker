<?= $this->extend('Admin/layout/principal'); ?>

<?= $this->section('titulo'); ?>

  <?= $title ?>

<?= $this->endSection(); ?>

<?= $this->section('estilos'); ?>

  <!-- Aqui enviamos para o layout principal os estilos -->

<?= $this->endSection(); ?>

<?= $this->section('conteudo'); ?>

  <!-- Aqui enviamos para o layout principal os conteúdos -->
  <?= $title ?>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

  <!-- Aqui enviamos para o layout principal os scripts -->

<?= $this->endSection(); ?>