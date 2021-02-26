<?= $this->extend('layout/tmpadm'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col mt-4">
            <?php if ($proses == 'user') : ?>
                <?= $this->include('users/tableuser'); ?>
            <?php endif; ?>
            <?php if ($proses == 'nasabah') : ?>
                <?= $this->include('anggota/tabanggota'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>
<?php if ($proses == 'user') : ?>
    <?= $this->include('users/scriptuser'); ?>
<?php endif; ?>