<?= $this->section('jvscript'); ?>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script>
    let STATUS_USER = [
        'Belum aktif',
        'Aktif',
        'Blockir',
        'Berhenti'
    ];
    $(document).ready(function() {
        show_record();
    });

    function show_record() {
        $('#mytable').DataTable({
            processing: true,
            serverSide: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'
            },
            bDestroy: true,
            responsive: true,
            order: [],
            ajax: {
                url: "<?php echo base_url('/users/user_ajax_list'); ?>",
                type: "POST",
                data: {},
            },
            columnDefs: [{
                    targets: [0, 1],
                    orderable: false,
                },
                {
                    width: "1%",
                    targets: [1, -1],
                },
                {
                    className: "dt-nowrap",
                    targets: [-1],
                }
            ],
        });
    }

    function clear_messages() {
        $('#username-error').html('');
        $('#password-error').html('');
        $('#usertype-error').html('');
    }

    function tutup_modal_tambah_user() {
        clear_messages();
        $('#ajaxTambahUSer').modal('hide');
    }

    function tambah_user() {
        clear_messages();
        $('#ajaxTambahUSer').modal('show');
        $('#form-tambah-user')[0].reset();
    }

    function proses_simpan_user() {
        clear_messages();
        $.ajax({
            url: '<?php echo base_url('users/simpan_user_baru'); ?>',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-tambah-user').serialize(),
            success: function(res) {
                if (res.errors) {
                    if (res.errors.username) {
                        $('#username-error').html(res.errors.username);
                    }
                    if (res.errors.password) {
                        $('#password-error').html(res.errors.password);
                    }
                    if (res.errors.usertype) {
                        $('#usertype-error').html(res.errors.usertype);
                    }
                }
                if (res.success == true) {
                    $('#message').removeClass('hide');
                    $('#message').html('<div class="alert alert-success alert-dismissible">\n\
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>\n\
                        <h5><i class="icon fa fa-info-circle"></i> <b>Success!</b> ' + res.message + '</h5></div>');
                    tutup_modal_tambah_user();
                    show_record();
                }
            }
        });
    }

    function clear_error_password() {
        $('#password1-error').html('');
        $('#password2-error').html('');
        $('#usernamelabel').html('');
    }

    function tutup_modal_password_user() {
        $('#ajaxPassword').modal('hide');
    }

    function ganti_password(id) {
        clear_error_password();
        $('#ajaxPassword').modal('show');
        $('#form-password-user')[0].reset();
        $.ajax({
            url: '<?php echo base_url('users/get_user'); ?>',
            type: 'POST',
            dataType: 'JSON',
            data: {
                id_password: id
            },
            success: function(res) {
                if (res.success == true) {
                    $('#usernamelabel').html('Username: ' + res.data.username);
                }
            }
        });
    }

    function proses_ganti_password_user() {
        $('#password1-error').html('');
        $('#password2-error').html('');
        
    }
</script>

<?= $this->endSection('jvscript'); ?>

<?= $this->section('dialogbox'); ?>
<!-- TAMBAH USER FORM -->
<div class="modal fade" id="ajaxTambahUSer" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajaxModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup_modal_tambah_user()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-tambah-user">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required="true">
                        <span><i class="text-danger" id="username-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="password" name="password" required="true">
                        <span><i class="text-danger" id="password-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="usertypeadmin" class="col-sm-2 col-form-label">Type User</label>
                        <div class="col-sm-10 mb-2">
                            <input class="form-check-input" type="radio" name="usertype" id="usertypeadmin" value="Admin">
                            <label class="form-check-label" for="usertypeadmin">
                                Admin
                            </label>
                            <input class="form-check-input" type="radio" name="usertype" id="usertypeanggota" value="Anggota">
                            <label class="form-check-label" for="usertypeanggota">
                                Anggota
                            </label>
                        </div>
                        <span><i class="text-danger" id="usertype-error"></i></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="tutup_modal_tambah_user()"><i class="fa fa-arrow-circle-left "></i>&nbsp;Close</button>
                <button type="button" class="btn btn-primary" onclick="proses_simpan_user()"><i class="fa fa-plus-circle"></i>&nbsp;Tambah User</button>
            </div>
        </div>
    </div>
</div>
<!-- TAMBAH USER FORM -->
<!-- PASSWORD USER FORM -->
<div class="modal fade" id="ajaxPassword" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajaxModalLabel">PASSWORD USER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup_modal_password_user()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-header">
                <h6 class="modal-title" id="usernamelabel">Username</h6>
            </div>
            <div class="modal-body">
                <form id="form-password-user">

                    <div class="form-group">
                        <label for="password1">Password1</label>
                        <input type="text" class="form-control" id="password1" name="password1" required="true">
                        <span><i class="text-danger" id="password1-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="password2">Password2</label>
                        <input type="text" class="form-control" id="password2" name="password2" required="true">
                        <span><i class="text-danger" id="password2-error"></i></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="tutup_modal_password_user()"><i class="fa fa-arrow-circle-left "></i>&nbsp;Close</button>
                <button type="button" class="btn btn-primary" onclick="proses_ganti_password_user()"><i class="fa fa-plus-circle"></i>&nbsp;Update</button>
            </div>
        </div>
    </div>
</div>
<!-- PASSWORD USER FORM -->


<?= $this->endSection('dialogbox'); ?>