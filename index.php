<?php require_once('./src/includes/header.php') ?>

<form id="formLogin">
     <section class="vh-100 gradient-custom">
          <div class="container py-5 h-100">
               <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                         <div class="card bg-dark text-white" style="border-radius: 1rem;">
                              <div class="card-body p-5 text-center">
                                   <h2 class="fw-bold mb-5">Login</h2>
                                   <div class="mb-md-3 mt-md-4 pb-3">
                                        <div class="notification mb-4" style="background: red;">
                                        </div>
                                        <div class="form-outline form-white mb-4">
                                             <input type="email" id="txtEmail" name="txtEmail"
                                                  class="form-control form-control-lg" placeholder="Email" />
                                        </div>
                                        <div class="form-outline form-white mb-4">
                                             <input type="password" id="txtPassword" name="txtPassword"
                                                  class="form-control form-control-lg" placeholder="Senha" />
                                        </div>
                                        <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                                   </div>
                                   <div>
                                        <p class="mb-0">Faça o cadastro aqui! <a href="./src/pages/register.php"
                                                  class="text-white-50 fw-bold">Inscreva-se</a></p>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </section>
</form>

<script>
     loginClient();
</script>

</body>

</html>