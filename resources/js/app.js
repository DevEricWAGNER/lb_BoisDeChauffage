import './bootstrap';

import Alpine from 'alpinejs';

var loader = document.getElementById('preloader');

window.addEventListener('load', function() {
    EndLoadingScreen();
});

function LoadingScreen() {
    setTimeout(() => { loader.style.display = 'flex'; }, 500);
}

function EndLoadingScreen() {
    setTimeout(() => { loader.style.display = 'none'; }, 500);
}

const url = "http://template.webserver.webwagner.fr/";
const siteUrl = "http://lbboisdechauffage.webserver.webwagner.fr/";

if (window.location.pathname == "/login" || window.location.pathname == "/register") {
    LoadingScreen();
    $.ajax({
        url: '/projectInfos',
        type: 'GET',
        success: function(response) {
            document.title = response.siteName;
            var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
            link.type = 'image/x-icon';
            link.rel = 'shortcut icon';
            link.href = url + 'storage/1/' + response.siteLogo;
            document.getElementsByTagName('head')[0].appendChild(link);
            const logo2 = document.getElementById('logo1');
            const logo1 = document.getElementById('logo2');
            logo1.src = url + 'storage/1/' + response.siteLogo;
            logo2.src = url + 'storage/1/' + response.siteLogo;
            EndLoadingScreen();
        }
    });
} else if (window.location.pathname == "/success" || window.location.pathname == "/cancel") {
    LoadingScreen();
    $.ajax({
        url: '/projectInfos',
        type: 'GET',
        success: function(response) {
            var html = "";
            document.title = response.siteName;
            var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
            link.type = 'image/x-icon';
            link.rel = 'shortcut icon';
            link.href = url + 'storage/1/' + response.siteLogo;
            document.getElementsByTagName('head')[0].appendChild(link);
            const logo_success = document.getElementById('logo_success');
            logo_success.src = url + 'storage/1/' + response.siteLogo;

            EndLoadingScreen();
        }
    });
} else {
    LoadingScreen();
    $.ajax({
        url: '/projectInfos',
        type: 'GET',
        success: function(response) {
            var html = "";
            document.title = response.siteName;
            var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
            link.type = 'image/x-icon';
            link.rel = 'shortcut icon';
            link.href = url + 'storage/1/' + response.siteLogo;
            document.getElementsByTagName('head')[0].appendChild(link);
            const logo = document.getElementById('logo');
            const logov1 = document.getElementById('logov1');
            logo.src = url + 'storage/1/' + response.siteLogo;
            logov1.src = url + 'storage/1/' + response.siteLogo;
            const HomePageLink = document.getElementById('HomePageLink')
            const HomePageLink2 = document.getElementById('HomePageLink2')
            if (response.viewHomePageLinkInNavbar == true) {
                HomePageLink.classList.remove("hidden")
                HomePageLink2.classList.remove("hidden")
            }
            if (response.siteLinkedin != "") {
                html += `
                <a href="https://" target="_blank" rel="noopener noreferrer">
                    <img class="lg:w-16 w-6" src="${siteUrl}storage/icons/social/Linkedin.png" alt="">
                </a>`;
            }
            if (response.siteInstagram != "") {
                html += `
                <a href="${response.siteInstagram}" target="_blank" rel="noopener noreferrer">
                    <img class="lg:w-16 w-6" src="${siteUrl}storage/icons/social/Instagram.png" alt="">
                </a>`;
            }
            html += `
            <a href="mailto:${response.siteEmail}" rel="noopener noreferrer">
                <img class="lg:w-16 w-6" src="${siteUrl}storage/icons/social/gmail.png" alt="">
            </a>`;
            if (response.siteYoutube != "") {
                html += `
                <a href="${response.siteYoutube}" target="_blank" rel="noopener noreferrer">
                    <img class="lg:w-16 w-6" src="${siteUrl}storage/icons/social/youtube.png" alt="">
                </a>`;
            }
            if (response.siteFacebook != "") {
                html += `
                <a href="${response.siteFacebook}" target="_blank" rel="noopener noreferrer">
                    <img class="lg:w-16 w-6" src="${siteUrl}storage/icons/social/facebook.png" alt="">
                </a>`;
            }
            const footerSocialLinks = document.getElementById('footer_social_links');
            if (footerSocialLinks) {
                footerSocialLinks.innerHTML = html;
            }

            EndLoadingScreen();
        }
    });

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
