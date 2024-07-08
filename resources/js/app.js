import './bootstrap';

import Alpine from 'alpinejs';

const url = "http://template.webserver.webwagner.fr/";
const siteUrl = "http://lbboisdechauffage.webserver.webwagner.fr/";

if (window.location.pathname == "/login" || window.location.pathname == "/register") {
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
        }
    });
} else {
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
            logo.src = url + 'storage/1/' + response.siteLogo;
            const HomePageLink = document.getElementById('HomePageLink')
            if (response.viewHomePageLinkInNavbar == true) {
                HomePageLink.classList.remove("hidden")
            }
            if (response.siteLinkedin != "") {
                html += `
                <a href="https://" target="_blank" rel="noopener noreferrer">
                    <img class="w-16" src="${siteUrl}storage/icons/social/Linkedin.png" alt="">
                </a>`;
            }
            if (response.siteInstagram != "") {
                html += `
                <a href="${response.siteInstagram}" target="_blank" rel="noopener noreferrer">
                    <img class="w-16" src="${siteUrl}storage/icons/social/Instagram.png" alt="">
                </a>`;
            }
            html += `
            <a href="mailto:${response.siteEmail}" rel="noopener noreferrer">
                <img class="w-16" src="${siteUrl}storage/icons/social/gmail.png" alt="">
            </a>`;
            if (response.siteYoutube != "") {
                html += `
                <a href="${response.siteYoutube}" target="_blank" rel="noopener noreferrer">
                    <img class="w-16" src="${siteUrl}storage/icons/social/youtube.png" alt="">
                </a>`;
            }
            if (response.siteFacebook != "") {
                html += `
                <a href="${response.siteFacebook}" target="_blank" rel="noopener noreferrer">
                    <img class="w-16" src="${siteUrl}storage/icons/social/facebook.png" alt="">
                </a>`;
            }
            const footerSocialLinks = document.getElementById('footer_social_links');
            if (footerSocialLinks) {
                footerSocialLinks.innerHTML = html;
            }
        }
    });
}

window.Alpine = Alpine;

Alpine.start();
