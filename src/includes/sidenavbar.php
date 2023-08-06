<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar navbar-dark">
        <a href="" class="navbar-brand mx-4 mb-3">
            <h1 class="text-primary" style="font-size: 14px;"><i class="fa fa-user-edit me-2"></i>Teste Tecnico Concept Prime</h1>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <i class="fa fa-user light me-2" style="font-size: 25px; color: white;"></i>
            </div>
            <div class="ms-3">
                <h6 class="name-user mb-0" style="color: white;"></h6>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="../pages/indexmaster.php" class="nav-item nav-link indexmaster"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <a href="../pages/registration.php" class="nav-item nav-link registration"><i class="fas fa-book-open me-2"></i>Cadastro</a>
        </div>
    </nav>
</div>
<!-- Sidebar End -->

<script>

	let current_url = window.location.href;
	let formatURL = current_url.slice(current_url.indexOf('pages')).split('/')[1];

    if(formatURL == 'registration.php') {
	    $('.registration').addClass('active');
	} 

    if(formatURL == 'indexmaster.php') {
	    $('.indexmaster').addClass('active');
	}

</script>