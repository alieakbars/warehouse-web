<!DOCTYPE html>
<html lang="en">

<?= $this->include('Admin/layout/Header') ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">


            <!-- Content Row -->
            <?= $this->renderSection('content') ?>
        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Bootstrap core JavaScript-->

        <script src="<?= base_url('assets_adm/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

        <!-- Core plugin JavaScript-->
        <script src="<?= base_url('assets_adm/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

        <!-- Custom scripts for all pages-->
        <script src="<?= base_url('assets_adm/js/sb-admin-2.min.js') ?>"></script>


        <!-- Page level custom scripts -->


</body>

</html>