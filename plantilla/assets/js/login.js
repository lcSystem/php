$(document).ready(function() {
    $("#loginUserPassword").submit(function(e) {
        e.preventDefault(); // detiene el envío normal

        $.ajax({
            url: 'controller/loginController.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    window.location.href = response.redirect;
                } else {
                    Swal.fire({
                        title: response.titulo,
                        text: response.mensaje,
                        icon: response.tipo,
                        confirmButtonText: 'Aceptar',
                        background: '#1a1a1a',
                        color: '#FFD700'
                    });
                }
            },
            error: function() {
                Swal.fire('Error', 'Ocurrió un error inesperado', 'error');
            }
        });
    });
});

$(document).ready(function() {
    $("#formRegister").submit(function(e) {
        e.preventDefault(); // detiene el envío normal

        $.ajax({
            url: 'controller/registroController.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    window.location.href = response.redirect;
                } else {
                    Swal.fire({
                        title: response.titulo,
                        text: response.mensaje,
                        icon: response.tipo,
                        confirmButtonText: 'Aceptar',
                        background: '#1a1a1a',
                        color: '#FFD700'
                    });
                }
            },
            error: function() {
                Swal.fire('Error', 'Ocurrió un error inesperado', 'error');
            }
        });
    });
});


    function showRegister() {
      document.getElementById("loginForm").classList.add("hidden");
      document.getElementById("registerForm").classList.remove("hidden");
    }
    function showLogin() {
      document.getElementById("registerForm").classList.add("hidden");
      document.getElementById("loginForm").classList.remove("hidden");
    }

window.onload = function() {
  document.getElementById("loginForm").classList.remove("hidden");
  document.getElementById("registerForm").classList.add("hidden");
};

function showForgotPassword() {
  document.getElementById("forgotPasswordModal").classList.remove("hidden");
}
function closeForgotPassword() {
  document.getElementById("forgotPasswordModal").classList.add("hidden");
}

// Enviar formulario de recuperación por AJAX
$("#forgotPasswordForm").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: 'controller/forgotPasswordController.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response){
            Swal.fire({
                title: response.titulo,
                text: response.mensaje,
                icon: response.tipo,
                confirmButtonText: 'Aceptar',
                background: '#1a1a1a',
                color: '#FFD700'
            });
            if(response.success) closeForgotPassword();
        },
        error: function(){
            Swal.fire('Error','Ocurrió un error inesperado','error');
        }
    });
});

// Mostrar/Ocultar contraseña con el ojito — robusto: busca input dentro del .input-field si no existe data-target
$(document).on('click', '.toggle-password', function(e) {
    e.preventDefault();
    var $icon = $(this);
    // primero intenta encontrar el input dentro del mismo .input-field
    var $input = $icon.closest('.input-field').find('input');

    if (!$input.length) {
        var target = $icon.data('target');
        if (target) $input = $('#' + target);
    }

    if (!$input.length) return; 

    if ($input.attr('type') === 'password') {
        $input.attr('type', 'text');
    } else {
        $input.attr('type', 'password');
    }

    // alterna clases del icono (fa-eye <-> fa-eye-slash)
    $icon.toggleClass('fa-eye fa-eye-slash');
});


 function openRegisterModal() {
            document.getElementById('registerModal').style.display = 'flex';
        }
        function closeRegisterModal() {
            document.getElementById('registerModal').style.display = 'none';
        }
