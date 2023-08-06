let URL = './API/connAPI.php';
let URLI = '../../API/connAPI.php';
let user = localStorage.getItem('user');
let item = localStorage.getItem('item');

//MODAL FUNÇÕES
function toggleModal(size = false) {
    let modal = $('.fp-modal');

    resizeModal(size);

    let statusModal = true;
    if (modal.is(':visible')) {
        statusModal = false;

        $('.c-modal').html('');
    }

    modal.attr('show', statusModal);
    $('.b-modal').scrollTop(0);

    $('.x-modal').click(function () {
        toggleModal();
    });
}

function resizeModal(size = false) {
    $('.b-modal').removeClass('modal-small modal-large');

    let classes = {
        'small': 'modal-small',
        'large': 'modal-large',
    };

    $('.b-modal').addClass((classes[size]) ? classes[size] : '');
}

//Loader 
function toggleLoader(action) {
    if (action == 'show') $('.x-loader').fadeIn(100);

    if (action == 'hide') $('.x-loader').fadeOut(100);
}

//MSG error
function showError(msg = false) {
    $('.alert-box-error').show();

    if (msg) {
        $('.msg').text(msg);
    }

    $('.loader').fadeOut();
}

function closeAlertBox() {
    $('.alert-box').hide();
    $('.alert-box .msg').text('');
    $('.btn-no-link').show();
    $('.btn-link').hide().attr('href', ' ');
}

function showSuccess(msg = false, url = false) {
    $('.alert-box-success').show();

    if (msg) {
        $('.alert-box .msg').text(msg);
    }

    if (url) {
        $('.btn-no-link').hide();
        $('.btn-link').show().attr('href', url);
    }
}

//Filter column
function toggleTableOrder(column, type) {
    let element = $(`span.order[data-column-order="${column}"]`);
    let order = element.attr('data-table-order');

    let infos = [];
    let table = column.split('-')[1];
    column = column.split('-')[0];

    $(`table.${table} tbody tr`).each(function (index, element) {
        let temp = {
            'content': $(element).find(`td[data-column="${column}"]`).text(),
            'order': parseInt($(element).attr('data-table-order')),
            'element': element
        };

        infos.push(temp);
    });

    $(`span.order i.fa-sort-up, span.order i.fa-sort-down`).removeClass('actived');

    let newOrder;

    switch (order) {
        case 'false':
            newOrder = 'Asc';
            $(`span.order[data-column-order="${column}-${table}"] i.fa-sort-up`).addClass('actived');
            break;
        case 'Asc':
            newOrder = 'Desc';
            $(`span.order[data-column-order="${column}-${table}"] i.fa-sort-down`).addClass('actived');
            break;
        case 'Desc':
            newOrder = 'false';
            break;
    }

    element.attr('data-table-order', newOrder)

    if (type == 'money') {
        for (let prop in infos) {
            let item = infos[prop];

            let money = item.content;

            money = money.replace(' ', ' ');
            let moneySplit = money.split(' ');

            money = moneySplit[1].replace(/[.]/g, '').replace(',', '.');

            if (moneySplit[0].substr(0, 1) == '-') {
                money = `-${money}`;
            }

            infos[prop]['content'] = parseFloat(money);
        }
    } else if (type == 'date') {
        for (let prop in infos) {
            let item = infos[prop];

            let datetime = item.content;
            let splitDate = datetime.split(' ');

            let date = splitDate[0].split('/').reverse().join('-');
            let hour = splitDate[1];

            let timestamp = new Date(date + ' ' + hour).getTime();

            infos[prop]['content'] = timestamp;
        }
    } else if (type == 'numeric') {
        for (let prop in infos) {
            let item = infos[prop];

            let numeric = item.content;

            infos[prop]['content'] = parseFloat(numeric);
        }
    }

    if (newOrder == 'Asc') {
        infos.sort(function (a, b) {
            return (a.content > b.content) ? 1 : ((b.content > a.content) ? -1 : 0);
        });
    } else if (newOrder == 'Desc') {
        infos.sort(function (a, b) {
            return (a.content < b.content) ? 1 : ((b.content < a.content) ? -1 : 0);
        });
    } else {
        infos.sort(function (a, b) {
            return (a.order > b.order) ? 1 : ((b.order > a.order) ? -1 : 0);
        });
    }

    $(`table.${table} tbody tr`).remove();

    for (let prop in infos) {
        let row = infos[prop];

        $(`table.${table} tbody`).append(row.element);
    }

}

//Validate cpf, onlyLetters, numbers
jQuery.validator.addMethod("cpf", function (value, element) {
    value = jQuery.trim(value);

    value = value.replace('.', '');
    value = value.replace('.', '');
    cpf = value.replace('-', '');
    while (cpf.length < 11) cpf = "0" + cpf;
    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
    var a = [];
    var b = new Number;
    var c = 11;
    for (i = 0; i < 11; i++) {
        a[i] = cpf.charAt(i);
        if (i < 9) b += (a[i] * --c);
    }
    if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11 - x }
    b = 0;
    c = 11;
    for (y = 0; y < 10; y++) b += (a[y] * c--);
    if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11 - x; }

    var retorno = true;
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

    return this.optional(element) || retorno;

}, "Informe um CPF válido");

jQuery.validator.addMethod("onlyLetters", function (value, element) {
    let number = /([0-9])/;
    if (value.match(number)) {
        return false;
    } else {
        return true;
    }
}, "Informe um nome válido");

jQuery.validator.addMethod("onlyNumbers", function (value, element) {
    let number = /([a-zA-Z])/;
    if (value.match(number)) {
        return false;
    } else {
        return true;
    }
}, "Informe um valor válido");

//Functions pages
function registerUser() {
    $('.x-loader').fadeOut();

    $('#registerForm').validate({
        rules: {
            txtName: {
                required: true,
                onlyLetters: true
            },
            txtEmail: {
                required: true,
                email: true
            },
            txtPassword: {
                required: true,
            },
            txtCPF: {
                required: true,
                cpf: true
            },
        },
        messages: {
            txtName: {
                required: 'Informe um nome',
                onlyLetters: 'Informe um nome válido'
            },
            txtEmail: {
                required: 'Informe um email',
                email: 'Informe um email válido'
            },
            txtPassword: {
                required: 'Informe uma senha'
            },
            txtCPF: {
                required: 'Informe um CPF',
                cpf: 'Informe um CPF válido'
            },
        },
        submitHandler: function (form) {

            let content = {
                'name': $('#txtName').val(),
                'email': $('#txtEmail').val(),
                'password': $('#txtPassword').val(),
                'cpf': $('#txtCPF').val()
            };

            $.ajax({
                type: 'POST',
                url: URLI,
                data: {
                    content: JSON.stringify(content),
                    API: 'registerUser'
                },
                success: function (obj) {
                    if (obj.status == 'erro') {
                        $('.notification').html(obj.data);
                    } else {
                        showSuccess('Cadastrado com sucesso!', '../../index.php');
                    }
                },
                error: function () {
                    $('.notification').html('Página não encontrada');
                }
            });
        }
    });
}

function loginClient() {
    $('.x-loader').fadeOut();

    $('#formLogin').validate({
        rules: {
            txtEmail: {
                required: true
            },
            txtPassword: {
                required: true,
                // minlength: 8
            },
        },
        messages: {
            txtEmail: {
                required: 'Informe um email'
            },
            txtPassword: {
                required: 'Informe sua senha'
            },
        },
        submitHandler: function (form) {

            let content = {
                'email': $('#txtEmail').val(),
                'password': $('#txtPassword').val(),
            };

            $.ajax({
                type: 'POST',
                url: URL,
                data: {
                    content: JSON.stringify(content),
                    API: 'loginClient'
                },
                success: function (obj) {
                    if (obj.data[0] == true) {
                        $(".notification").empty();

                        let key = obj.data[1];
                        localStorage.setItem('user', key);
                        window.location.href = './src/pages/indexmaster.php'

                    } else if (obj.status == 'erro') {
                        $('.notification').html(obj.data);
                    }
                },
                error: function () {
                    $('.notification').html('Página não encontrada');
                }
            });
        }
    });
}

function logout() {
    localStorage.removeItem('user')
    window.location.href = '../pages/logout.php'
}

function getUser() {
    $('.x-loader').fadeIn();

    let user = localStorage.getItem('user');

    $.ajax({
        type: 'POST',
        url: URLI,
        data: {
            content: JSON.stringify(user),
            API: 'getUser',
        },
        success: function (obj) {
            if (obj.status == 'erro') {
                showError(obj.data);
            } else {
                $('.name-user').append(obj.data.name);
                $('.x-loader').fadeOut();
            }
        },
        error: function () {
            showError('Erro interno');
        }
    })
}


function getCollaborators(action = false) {
    $('.x-loader').fadeIn();

    if (action == 'previous' || action == 'next') {
        action == 'previous' ? page-- : page++;
    } else {
        page = 1
    };

    let content = {
        'page': page,
        'limit': 10,
    };

    $.ajax({
        type: 'POST',
        url: URLI,
        data: {
            content: JSON.stringify(content),
            API: 'getCollaborators',
        },
        success: function (obj) {
            if (obj.status == 'erro') {
                showError(obj.data);
            } else {
                $('.page-number').text(page);

                organizeCollaborators(obj.data);
                $('.x-loader').fadeOut();
            }
        },
        error: function () {
            showError('Erro interno');
        }
    });

}

function organizeCollaborators(collaborators) {
    $('table.collaborators tbody').empty();
    let limit = 10;

    for (var prop in collaborators) {
        let Collaborator = collaborators[prop];
        let html = $('#templateCollaborators').html();

        html = html.replace('{{order}}', Collaborator.nome);
        html = html.replace(/{{id}}/g, Collaborator.id);
        html = html.replace(/{{nome}}/g, Collaborator.nome);
        html = html.replace(/{{sobrenome}}/g, Collaborator.sobrenome);
        html = html.replace(/{{CEP}}/g, Collaborator.CEP);
        html = html.replace(/{{cidade}}/g, Collaborator.cidade);
        html = html.replace(/{{estado}}/g, Collaborator.estado);
        html = html.replace(/{{longradouro}}/g, Collaborator.logradouro);
        html = html.replace(/{{numero}}/g, Collaborator.numero);
        html = html.replace(/{{bairro}}/g, Collaborator.bairro);
        html = html.replace(/{{complemento}}/g, Collaborator.complemento);

        $('table.collaborators tbody').append(html);
    }

    if (page > 1) {
        $('.previous').show();
    } else {
        $('.previous').hide();
    }

    if (user.length < limit) {
        $('.next').hide();
    } else {
        $('.next').show();
    }
}

function searchCollaborators(action = false) {
    $('.loader').fadeIn();

    let search = $('input[name="txtSearch"]').val();
    $('.previous').hide();
    $('.next').hide();

    if (action == 'previousSearch' || action == 'nextSearch') {
        action == 'previousSearch' ? page-- : page++;
    } else {
        page = 1
    };

    let content = {
        'search': search,
        'page': page,
        'limit': 10,
    };

    $.ajax({
        type: 'POST',
        url: URLI,
        data: {
            content: JSON.stringify(content),
            API: 'searchCollaborators',
        },
        success: function (response) {
            let obj = response;

            if (obj.status == 'erro') {
                showError(obj.data);
            } else {
                let collaborators = obj.data;

                page == 1 && collaborators.length < 10 ? $('.page-number').hide() : $('.page-number').show();

                $('.page-number').text(page);
                organizeSearch(collaborators);
                $('.loader').fadeOut();
            }
        },
        error: function () {
            showError('Erro interno');
        }
    });

}

function organizeSearch(collaborator) {
    $('table.collaborators tbody').empty();
    let limit = 10;

    for (var prop in collaborator) {
        let collaborators = collaborator[prop];
        let html = $('#templateCollaborators').html();

        html = html.replace('{{order}}', collaborators.nome);
        html = html.replace(/{{id}}/g, collaborators.id);
        html = html.replace(/{{nome}}/g, collaborators.nome);
        html = html.replace(/{{sobrenome}}/g, collaborators.sobrenome);
        html = html.replace(/{{CEP}}/g, collaborators.CEP);
        html = html.replace(/{{cidade}}/g, collaborators.cidade);
        html = html.replace(/{{estado}}/g, collaborators.estado);
        html = html.replace(/{{longradouro}}/g, collaborators.logradouro);
        html = html.replace(/{{numero}}/g, collaborators.numero);
        html = html.replace(/{{bairro}}/g, collaborators.bairro);
        html = html.replace(/{{complemento}}/g, collaborators.complemento);

        $('table.collaborators tbody').append(html);
    }

    if (page > 1) {
        $('.previousSearch').show();
    } else {
        $('.previousSearch').hide();
    }

    if (collaborator.length < limit) {
        $('.nextSearch').hide();
    } else {
        $('.nextSearch').show();
    }
}

function loadChart() {
    $('.x-loader').fadeIn();

    const ctx = document.getElementById('line-chart');

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Cadastro'],
            datasets: [{
                label: 'Colaboradores',
                data: [],
                borderColor: 'rgb(0, 180, 216)',
                backgroundColor: 'rgb(0, 180, 216)',
            }]
        },

    });

    $.ajax({
        type: 'POST',
        url: URLI,
        data: {
            content: JSON.stringify(user),
            API: 'loadChart',
        },
        success: function (obj) {
            if (obj.status == 'erro') {
                showError(obj.data);
            } else {
                let collaborators = obj.data.collaborators.collaborators;

                myChart.data.datasets[0].data.push(collaborators);

                myChart.update();
                $('.x-loader').fadeOut();
            }
        },
        error: function () {
            showError('Erro interno');
        }

    })
}

function registrationCollaborators() {
    $('.x-loader').fadeIn();
    $('.inputSearch').hide();
    $('.btn-search').hide();

    $('#formRegistration').validate({
        rules: {
            txtNome: {
                required: true,
                onlyLetters: true
            },
            txtSobrenome: {
                required: true,
                onlyLetters: true
            },
            txtCEP: {
                required: true,
                // cep: true // Você pode criar essa regra personalizada
            },
            txtCidade: {
                required: true
            },
            txtEstado: {
                required: true
            },
            txtLogradouro: {
                required: true
            },
            txtNumero: {
                onlyNumbers: true,
                required: true
            },
            txtBairro: {
                required: true
            },
            txtComplemento: {
                required: false
            }
        },
        messages: {
            txtNome: {
                required: 'Informe um nome',
                onlyLetters: 'Informe um nome válido'
            },
            txtSobrenome: {
                required: 'Informe um sobrenome',
                onlyLetters: 'Informe um sobrenome válido'
            },
            txtCEP: {
                required: 'Informe um CEP',
                cep: 'Informe um CEP válido'
            },
            txtCidade: {
                required: 'Informe uma cidade'
            },
            txtEstado: {
                required: 'Informe um estado'
            },
            txtLogradouro: {
                required: 'Informe um logradouro'
            },
            txtNumero: {
                required: 'Informe um número',
                onlyNumbers: 'Informe apenas números'
            },
            txtBairro: {
                required: 'Informe um bairro'
            },
        },
        submitHandler: function (form) {

            let nome = $('#txtNome').val();
            let sobrenome = $('#txtSobrenome').val();
            let CEP = $('#txtCEP').val();
            let cidade = $('#txtCidade').val();
            let estado = $('#txtEstado').val();
            let logradouro = $('#txtLogradouro').val();
            let numero = $('#txtNumero').val();
            let bairro = $('#txtBairro').val();
            let complemento = $('#txtComplemento').val();

            autheticationCollaborators(nome, sobrenome, CEP, cidade, estado, logradouro, numero, bairro, complemento);
        }
    });
}

function limpa_formulário_cep() {
    document.getElementById('txtBairro').value=("");
    document.getElementById('txtCidade').value=("");
    document.getElementById('txtEstado').value=("");
    document.getElementById('txtLogradouro').value=("");
}

function pesquisacep(valor) {
    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('txtBairro').value="...";
            document.getElementById('txtCidade').value="...";
            document.getElementById('txtEstado').value="...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

            document.body.appendChild(script);
        } else {
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } else {
        limpa_formulário_cep();
    }
};

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        document.getElementById('txtBairro').value=(conteudo.bairro);
        document.getElementById('txtCidade').value=(conteudo.localidade);
        document.getElementById('txtEstado').value=(conteudo.uf);
        document.getElementById('txtLogradouro').value=(conteudo.logradouro);
    } else {
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function autheticationCollaborators(nome, sobrenome, CEP, cidade, estado, logradouro, numero, bairro, complemento) {
    $('.h-modal-title').html('Confimar colaborador');
    let html = $('#templateCollaborators').html();
    $('.c-modal').html(html);

    toggleModal();

    $('#form-collaborators').validate({
        rules: {
            txtPassword: {
                required: true
            },
        },
        messages: {
            txtPassword: {
                required: 'Informe sua senha atual'
            }
        },
        submitHandler: function (form) {

            let content = {
                'nome': nome,
                'sobrenome': sobrenome,
                'CEP': CEP,
                'cidade': cidade,
                'estado': estado,
                'logradouro': logradouro,
                'numero': numero,
                'bairro': bairro,
                'complemento': complemento,
                'password': $('#txtPassword').val(),
                'user': user
            };

            $.ajax({
                type: 'POST',
                url: URLI,
                data: {
                    content: JSON.stringify(content),
                    API: 'registrationCollaborators'
                },
                success: function (obj) {
                    if (obj.status == 'erro') {
                        showError(obj.data);
                    } else {
                        showSuccess('Cadastrado com sucesso!', '../pages/indexmaster.php');
                        toggleModal();
                    }
                },
                error: function () {
                    showError('Erro interno');
                }
            });
        }
    });
}

function updateUser(id, nome, sobrenome, CEP, cidade, estado, logradouro, numero, bairro, complemento) {
    $('.h-modal-title').html('Editando o ' + nome);
    let html = $('#templateEdit').html();
    $('.c-modal').html(html);

    toggleModal();

    $('input[name="txtNome"]').val(nome);
    $('input[name="txtSobrenome"]').val(sobrenome);
    $('input[name="txtCEP"]').val(CEP);
    $('input[name="txtCidade"]').val(cidade);
    $('input[name="txtEstado"]').val(estado);
    $('input[name="txtLogradouro"]').val(logradouro);
    $('input[name="txtNumero"]').val(numero);
    $('input[name="txtBairro"]').val(bairro);
    $('input[name="txtComplemento"]').val(complemento);

    $('#editForm').validate({
        rules: {
            txtNome: {
                required: true,
                onlyLetters: true
            },
            txtSobrenome: {
                required: true,
                onlyLetters: true
            },
            txtCEP: {
                required: true,
            },
            txtCidade: {
                required: true
            },
            txtEstado: {
                required: true
            },
            txtLogradouro: {
                required: true
            },
            txtNumero: {
                onlyNumbers: true,
                required: true
            },
            txtBairro: {
                required: true
            },
            txtComplemento: {
                required: false
            }
        },
        messages: {
            txtNome: {
                required: 'Informe um nome',
                onlyLetters: 'Informe um nome válido'
            },
            txtSobrenome: {
                required: 'Informe um sobrenome',
                onlyLetters: 'Informe um sobrenome válido'
            },
            txtCEP: {
                required: 'Informe um CEP',
                cep: 'Informe um CEP válido'
            },
            txtCidade: {
                required: 'Informe uma cidade'
            },
            txtEstado: {
                required: 'Informe um estado'
            },
            txtLogradouro: {
                required: 'Informe um logradouro'
            },
            txtNumero: {
                required: 'Informe um número',
                onlyNumbers: 'Informe apenas números'
            },
            txtBairro: {
                required: 'Informe um bairro'
            },
        },
        submitHandler: function (form) {

            let content = {
                'nome': $('#txtNome').val(),
                'sobrenome': $('#txtSobrenome').val(),
                'CEP': $('#txtCEP').val(),
                'cidade': $('#txtCidade').val(),
                'estado': $('#txtEstado').val(),
                'logradouro': $('#txtLogradouro').val(),
                'numero': $('#txtNumero').val(),
                'bairro': $('#txtBairro').val(),
                'complemento': $('#txtComplemento').val(),
                'password': $('#txtPassword').val(),
                'id': id,
                'user': user
            };

            $.ajax({
                type: 'POST',
                url: URLI,
                data: {
                    content: JSON.stringify(content),
                    API: 'editCollaborators'
                },
                success: function (obj) {
                    if (obj.status == 'erro') {
                        showError(obj.data);
                    } else {
                        showSuccess('Editado com sucesso!', '../pages/indexmaster.php');
                    }
                },
                error: function () {
                    $('.notification').html('Página não encontrada');
                }
            });
        }
    });
}

function deleteCollaborators(id, name) {
    $('.h-modal-title').html('Excluir usuário');
    let html = $('#templateDelete').html();
    $('.c-modal').html(html);
    $('p').text('Deseja realmente excluir o ' + name + ' ?');

    toggleModal();

    $('#deleteForm').validate({
        rules: {
            txtPassword: {
                required: true
            },
        },
        messages: {
            txtPassword: {
                required: 'Informe sua senha atual'
            }
        },
        submitHandler: function (form) {

            let content = {
                'id': id,
                'password': $('#txtPassword').val(),
                'user': user
            };

            $.ajax({
                type: 'POST',
                url: URLI,
                data: {
                    content: JSON.stringify(content),
                    API: 'deleteCollaborators'
                },
                success: function (obj) {
                    if (obj.status == 'erro') {
                        showError(obj.data);
                    } else {
                        showSuccess('Excluído com sucesso!', '../pages/indexmaster.php');
                        toggleModal();
                    }
                },
                error: function () {
                    showError('Erro interno');
                }
            });
        }
    });
}