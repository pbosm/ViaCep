<?php require_once('../../src/includes/headerRegister.php') ?>

<form id="registerForm">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mt-md-4 pb-2">
                                <h2 class="fw-bold mb-2">Faça seu cadastro!</h2>
                                <div class="notification mb-4" style="background: red;">
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <input type="text" id="txtName" name="txtName" class="form-control form-control-lg"
                                        placeholder="Nome" />
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <input type="email" id="txtEmail" name="txtEmail" class="form-control form-control-lg"
                                        placeholder="Email" />
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <input type="password" id="txtPassword" name="txtPassword" class="form-control form-control-lg"
                                        placeholder="Senha" />
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <input type="text" id="txtCPF" name="txtCPF" class="form-control form-control-lg"
                                        placeholder="CPF" />
                                </div>
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Cadastrar</button>
                            </div>
                            <div>
                                <p class="mt-4">Ir para página de login! <a href="../../index.php"
                                        class="text-white-50 fw-bold">Login</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

<script>
    registerUser();
</script>

</body>

</html>