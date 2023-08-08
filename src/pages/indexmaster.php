<?php require_once('../includes/headerUser.php') ?>
<?php require_once('../includes/sidenavbar.php') ?>
<?php require_once('../includes/content.php') ?>

<script type="text/html" id="templateCollaborators">
<tr data-table-order="{{order}}">
    <td data-column="nome" style="white-space: nowrap">
        {{nome}}
    </td>
    <td data-column="sobrenome" style="white-space: nowrap">
        {{sobrenome}}
    </td>
    <td data-column="CEP" style="white-space: nowrap">
        {{CEP}}
    </td>
    <td data-column="cidade" style="white-space: nowrap">
        {{cidade}}
    </td>
    <td data-column="estado" style="white-space: nowrap">
        {{estado}}
    </td>
    <td data-column="logradouro" style="white-space: nowrap">
        {{logradouro}}
    </td>
    <td data-column="numero" style="white-space: nowrap">
        {{numero}}
    </td>
    <td data-column="bairro" style="white-space: nowrap">
        {{bairro}}
    </td>
    <td data-column="complemento" style="white-space: nowrap">
        {{complemento}}
    </td>
    <td style="white-space: nowrap;" class="text-center">
        <button class="btn btn-actions" onclick="updateUser('{{id}}', '{{nome}}', '{{sobrenome}}', '{{CEP}}', '{{cidade}}', '{{estado}}', '{{longradouro}}', '{{numero}}', '{{bairro}}', '{{complemento}}')" tooltip="Editar usuário" style="background-color: #0d6efd;">
            <i class="fas fa-edit"></i>
        </button>
    </td>
    <td style="white-space: nowrap;" class="text-center">
        <button class="btn btn-actions" onclick="deleteCollaborators('{{id}}', '{{nome}}')" tooltip="Excluir usuário" style="background-color: #0d6efd;">
            <i class="fas fa-user-times"></i>
        </button>
    </td>
</tr>
</script>

<script type="text/html" id="templateEdit">
<div class="row ml-0">
    <div class="col-12">
        <form id="editForm">
            <div class="row ml-0">
            <div class="col-md-6 mb-4">
                <div class="form-outline">
                    <label class="mb-2" for="txtNome">Nome</label>
                    <input class="form-control form-control-lg" type="text" id="txtNome"
                        name="txtNome">
                </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-outline">
                        <label class="mb-2" for="txtSobrenome">Sobrenome</label>
                        <input class="form-control form-control-lg" type="text" id="txtSobrenome"
                            name="txtSobrenome">
                    </div>
                </div>
                <div class="col-md-6 mb-4 pb-2">
                    <div class="form-outline">
                        <label class="mb-2" for="txtCEP">CEP</label>
                        <input class="form-control form-control-lg" type="text" id="txtCEP" value=""
                            size="10" maxlength="9" name="txtCEP" onblur="pesquisacep(this.value);">
                    </div>
                </div>
                <div class="col-md-6 mb-4 pb-2">
                    <div class="form-outline">
                        <label class="mb-2" for="txtCidade">Cidade</label>
                        <input class="form-control form-control-lg" type="text" id="txtCidade"
                            name="txtCidade" disabled>
                    </div>
                </div>
                <div class="col-md-6 mb-4 pb-2">
                    <div class="form-outline">
                        <label class="mb-2" for="txtEstado">Estado</label>
                        <input class="form-control form-control-lg" type="text" id="txtEstado"
                            name="txtEstado" disabled>
                    </div>
                </div>
                <div class="col-md-6 mb-4 pb-2">
                    <div class="form-outline">
                        <label class="mb-2" for="txtLogradouro">Logradouro</label>
                        <input class="form-control form-control-lg" type="text" id="txtLogradouro"
                            name="txtLogradouro" disabled>
                    </div>
                </div>
                <div class="col-md-6 mb-4 pb-2">
                    <div class="form-outline">
                        <label class="mb-2" for="txtNumero">Número</label>
                        <input class="form-control form-control-lg" type="text" id="txtNumero"
                            name="txtNumero">
                    </div>
                </div>
                <div class="col-md-6 mb-4 pb-2">
                    <div class="form-outline">
                        <label class="mb-2" for="txtBairro">Bairro</label>
                        <input class="form-control form-control-lg" type="text" id="txtBairro"
                            name="txtBairro" disabled>
                    </div>
                </div>
                <div class="col-md-6 mb-4 pb-2">
                    <div class="form-outline">
                        <label class="mb-2" for="txtComplemento">Complemento</label>
                        <input class="form-control form-control-lg" type="text" id="txtComplemento"
                            name="txtComplemento">
                    </div>
                </div>
                <div class="col-md-6 mb-4 pb-2">
                    <label for="txtPassword" class="mb-2">Senha</label>
                    <input type="password" class="form-control form-control-lg" id="txtPassword">
                </div>
                <button class="btn w-100 mt-3" style="background-color: aqua;">Confirmar</button>
            </div>
        </form>
    </div>
</div>
</script>

<script type="text/html" id="templateDelete">
    <form id="deleteForm">
        <div class="row ml-0">
            <div class="col-12">
                <p class="teste">Tem certeza que deseja excluir usuario?</p>
            </div>
            <div class="col-12 mt-0">               
                <div class="form-group">
                    <label for="txtPassword">Senha</label>
                    <input type="password" id="txtPassword" name="txtPassword">
                </div>
                    <button class="btn w-100 mt-3" style="background-color: aqua;">Confirmar</button>
            </div>
        </div>
    </form>
</script>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-9" id="table-collaborators">
            <div class="table-responsive">
                <table class="table table-striped collaborators">
                    <thead>
                        <tr>
                            <th>Nome
                                <span class="order" data-table-order="false" data-column-order="nome-collaborators"
                                    onclick="toggleTableOrder('nome-collaborators', 'alphabet')">
                                    <i class="fas fa-sort-up"></i>
                                    <i class="fas fa-sort-down"></i>
                                </span>
                            </th>
                            <th>Sobrenome
                                <span class="order" data-table-order="false" data-column-order="sobrenome-collaborators"
                                    onclick="toggleTableOrder('sobrenome-collaborators', 'alphabet')">
                                    <i class="fas fa-sort-up"></i>
                                    <i class="fas fa-sort-down"></i>
                                </span>
                            </th>
                            <th>CEP
                                <span class="order" data-table-order="false" data-column-order="CEP-collaborators"
                                    onclick="toggleTableOrder('CEP-collaborators', 'numeric')">
                                    <i class="fas fa-sort-up"></i>
                                    <i class="fas fa-sort-down"></i>
                                </span>
                            </th>
                            <th>Cidade
                                <span class="order" data-table-order="false" data-column-order="cidade-collaborators"
                                    onclick="toggleTableOrder('cidade-collaborators', 'alphabet')">
                                    <i class="fas fa-sort-up"></i>
                                    <i class="fas fa-sort-down"></i>
                                </span>
                            </th>
                            <th>Estado
                                <span class="order" data-table-order="false" data-column-order="estado-collaborators"
                                    onclick="toggleTableOrder('estado-collaborators', 'alphabet')">
                                    <i class="fas fa-sort-up"></i>
                                    <i class="fas fa-sort-down"></i>
                                </span>
                            </th>
                            <th>Logradouro
                                <span class="order" data-table-order="false" data-column-order="logradouro-collaborators"
                                    onclick="toggleTableOrder('logradouro-collaborators', 'alphabet')">
                                    <i class="fas fa-sort-up"></i>
                                    <i class="fas fa-sort-down"></i>
                                </span>
                            </th>
                            <th>Número
                                <span class="order" data-table-order="false" data-column-order="numero-collaborators"
                                    onclick="toggleTableOrder('numero-collaborators', 'numeric')">
                                    <i class="fas fa-sort-up"></i>
                                    <i class="fas fa-sort-down"></i>
                                </span>
                            </th>
                            <th>Bairro
                                <span class="order" data-table-order="false" data-column-order="bairro-collaborators"
                                    onclick="toggleTableOrder('bairro-collaborators', 'alphabet')">
                                    <i class="fas fa-sort-up"></i>
                                    <i class="fas fa-sort-down"></i>
                                </span>
                            </th>
                            <th>Complemento
                                <span class="order" data-table-order="false" data-column-order="complemento-collaborators"
                                    onclick="toggleTableOrder('complemento-collaborators', 'alphabet')">
                                    <i class="fas fa-sort-up"></i>
                                    <i class="fas fa-sort-down"></i>
                                </span>
                            </th>
                            <th style="white-space: nowrap;"></th>
                            <th style="white-space: nowrap;"></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-3">
            <div class="rounded p-4" style="height: 97%; background-color: antiquewhite;">
                <h6 class="texto-canvas mb-4" style="text-align: center;">Registros de cadastro</h6>
                <canvas id="line-chart"></canvas>
            </div>
        </div>
        <nav class="page-navigation" aria-label="Page navigation">
            <ul class="pagination justify-content-end">
                <li class="page-item">
                    <a class="previous page-link" href="javascript: getCollaborators('previous');">Anterior</a>
                    <a class="previousSearch page-link" href="javascript: searchCollaborators('previousSearch');"
                        style="display: none;">Anterior</a>
                </li>
                <li class="page-item"><a class="page-link page-number">1</a></li>
                <li class="page-item">
                    <a class="next page-link" href="javascript: getCollaborators('next');">Próximo</a>
                    <a class="nextSearch page-link" href="javascript: searchCollaborators('nextSearch');"
                        style="display: none;">Próximo</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<?php require_once('../includes/footer.php') ?>

<script>
    getUser();
    getCollaborators();
    loadChart();
</script>