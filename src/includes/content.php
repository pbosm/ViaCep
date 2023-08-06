<!-- Content Start -->
<div class="content">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand navbar-dark sticky-top px-4" style="background-color: var(--secondary);">
        <a href="" class="navbar-brand d-flex d-lg-none me-4">
            <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
        </a>
        <div id="formSearch" class="d-none d-md-flex">
            <input name="txtSearch" class="inputSearch form-control bg-dark border-0" type="search" placeholder="Search"
                style="color: white;">
            <a class="btn btn-search ms-2" href="javascript:searchCollaborators()" style="background-color: #0d6efd;">Pesquisar</a>
        </div>
        <div class="navbar-nav align-items-center ms-auto">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-user me-2"></i>
                    <span class="name-user d-none d-lg-inline-flex"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-primary border-0 rounded-0 rounded-bottom m-0">
                    <a href="javascript:logout()" class="dropdown-item">Sair</a>
                </div>
                <div class="d-md-none d-block">
                    <a href="../pages/indexmaster.php" class="nav-item nav-link indexmaster"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="../pages/registration.php" class="nav-item nav-link registration"><i class="fas fa-book-open me-2"></i>Cadastro</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->