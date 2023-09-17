<?= $this->extend('Admin/layout/Admin_layout_login') ?>

<?= $this->section('content') ?>

<section class="vh-100" style="background-color: #ed1c24;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?php echo session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <form method="post" action="<?= base_url(); ?>/loginController/process">
                        <?= csrf_field(); ?>
                        <div class="card-body p-5 text-center">
                            <img src="<?= base_url(); ?>/assets_adm/img/logo1.png" style="height: 170px; width: 170px;" />
                            <h3 class="mb-3 mt-3">Login</h3>
                            <!-- <?= password_hash('admin2023', PASSWORD_DEFAULT) ?> -->

                            <div class="form-outline mb-4">
                                <input type="text" id="typeEmailX-2" name="username" class="form-control form-control-lg" required />
                                <label class="form-label" for="typeEmailX-2">Username</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="typePasswordX-2" name="password" class="form-control form-control-lg" required />
                                <label class="form-label" for="typePasswordX-2">Password</label>
                            </div>

                            <!-- Checkbox -->
                            <div class="form-check d-flex justify-content-start mb-4">
                                <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                                <label class="form-check-label" for="form1Example3"> Remember password </label>
                            </div>

                            <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

                            <hr class="my-4">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>