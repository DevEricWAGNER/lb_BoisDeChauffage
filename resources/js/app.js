import './bootstrap';
import 'flowbite';


import Alpine from 'alpinejs';

function fadeOutEffect() {
    var alert = document.getElementById('alert-additional-content-2');
    if (alert) {
        alert.style.transition = 'opacity 0.5s ease-out';
        alert.style.opacity = '0';
        setTimeout(function() {
            alert.remove();
        }, 500); // Supprimer l'élément après l'animation de 0.5s
    }
}

// Déclencher automatiquement le fade-out après 5 secondes
setTimeout(fadeOutEffect, 5000);

if (window.location.pathname != "/login" && window.location.pathname != "/register" && window.location.pathname != "/success" && window.location.pathname != "/cancel") {

    $("#user-menu-button").click(function() {
        $("#user-menu").toggleClass("hidden");
    });

    $("#user-menu").click(function() {
        $("#user-menu").toggleClass("hidden");
    });

    document.getElementById("user-menu-button").addEventListener("mouseover", function (event) {
        document.getElementById("user_name_infos").classList.remove("w-0");
        document.getElementById("user_name_infos").classList.add("w-fit");
        document.getElementById("user_name_infos").classList.add("ml-2");
    })
    document.getElementById("user-menu-button").addEventListener("mouseout", function (event) {
        document.getElementById("user_name_infos").classList.remove("w-fit");
        document.getElementById("user_name_infos").classList.remove("ml-2");
        document.getElementById("user_name_infos").classList.add("w-0");
    })

    $(document).on('click', '.show_details', function() {
        const article = $(this).closest('article')
        const id = article.data('id')
        $.ajax({
            url: '/showDetails/' + id,
            type: 'GET',
            success: function(response) {
                if (response.error) {
                    // Gérer l'erreur si la commande n'est pas trouvée
                    console.error('Erreur:', response.error);
                    return;
                }
                $('#commandeModal').show();
                $('#modal-body').html(response.html);
            },
            error: function(xhr) {
                // Gérer les erreurs AJAX
                console.error('Erreur:', xhr.responseText);
            }
        })
    })

    $(document).on('click', '.close', function() {
        $('#commandeModal').hide();
    });

    // Fermer le modal quand l'utilisateur clique en dehors du contenu du modal
    $(window).on('click', function(event) {
        if ($(event.target).is('#commandeModal')) {
            $('#commandeModal').hide();
        }
    });

}

document.addEventListener('DOMContentLoaded', function() {
    // open
    const burger = document.querySelectorAll('.navbar-burger');
    const menu = document.querySelectorAll('.navbar-menu');

    if (burger.length && menu.length) {
        for (var i = 0; i < burger.length; i++) {
            burger[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }

    // close
    const close = document.querySelectorAll('.navbar-close');
    const backdrop = document.querySelectorAll('.navbar-backdrop');

    if (close.length) {
        for (var i = 0; i < close.length; i++) {
            close[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }

    if (backdrop.length) {
        for (var i = 0; i < backdrop.length; i++) {
            backdrop[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }
});

window.Alpine = Alpine;

Alpine.start();
