require("./bootstrap");
require("./shortcuts");
require("./tribute");
import { isInViewport } from "observe-element-in-viewport";
import lightbox from "lightbox2/dist/js/lightbox";
import "livewire-turbolinks";
var Turbolinks = require("turbolinks");
Turbolinks.start();

window.lightbox = lightbox;
window.lightbox.option({
    disableScrolling: true,
    fadeDuration: 100,
    imageFadeDuration: 100,
    resizeDuration: 300,
    fitImagesInViewport: true,
    maxWidth: 1000,
});

document.addEventListener("DOMContentLoaded", () => {
    (async () => {
        const target = document.querySelector("#load-more");
        if (await isInViewport(target)) {
            document.getElementById("load-more").click();
            document.getElementById("load-more").innerHTML = "Loading";
            document.getElementById("load-more").disabled = true;
        }
    })();
}, false);

window.addEventListener('scroll', () => {
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
    if (scrollTop + window.innerHeight > document.documentElement.scrollHeight - 100) {
        document.getElementById("load-more").click();
        document.getElementById("load-more").innerHTML = "Loading";
        document.getElementById("load-more").disabled = true;
    }
});

// Admin Bar toggle in dropdown
document.addEventListener("turbolinks:load", () => {
    document.getElementById("admin-bar-click").addEventListener("click", () => {
        window.fetch("/admin/adminbar")
            .then(async r => {
                const data = await r.text();
                if (data === "enabled" || data === "disabled") {
                    if (r.status === 200) {
                        window.location.reload();
                    }
                }
            });
    });
});

// Dark mode toggle in dropdown
document.addEventListener("turbolinks:load", () => {
    document.getElementById("dark-mode").addEventListener("click", () => {
        window.fetch("/darkmode")
            .then(async r => {
                const data = await r.text();
                if (data === "enabled" || data === "disabled") {
                    if (r.status === 200) {
                        window.location.reload();
                    }
                }
            });
    });
});

// Hide Alert
document.addEventListener("livewire:load", () => {
    window.Livewire.hook("element.updated", () => {
        setTimeout(() => {
            $(".fade").fadeOut("fast");
        }, 2000);
    });
});

// Hide search dropdown on clicking the body
document.body.addEventListener("click", () => {
    $("ul").remove(".search-dropdown");
});

document.addEventListener("turbolinks:load", () => {
    $("[data-toggle='tooltip']").tooltip();
});

document.addEventListener("turbolinks:load", () => {
    $(".user-hover").hover(
        onUserHover,
        function () {
            $(this).popover("toggle")
            $(this).popover("dispose")
        }
    );

    function onUserHover() {
        var $el = $(this);
        var content = $el.attr("data-content");
        var id = $el.attr("data-id");
        if (content === "") {
            $.get(`/hovercard/user/${id}`, function (data) {
                setTimeout(function () {
                    $el.attr("data-content", getUserData(data));
                    $el.popover("show");
                }, 350);
            }).fail(function () {
                console.log("error");
            });
        } else {
            setTimeout(function () {
                $el.popover("show");
            }, 350);
        }
    }

    function getUserData(data) {
        return `
    <div class="d-flex">
      <img class="avatar-40 rounded-circle mr-2" src="${data.avatar}" />
      <div>
        <div class="font-weight-bold">${data.firstname ? data.firstname : ''} ${data.lastname ? data.lastname : ''}</div>
        <div class="small">@${data.username}</div>
        ${data.bio ? `
        <div class="mt-2">
          ${data.bio}
        </div>` : ``
            }
        ${data.location ? `
        <div class="mt-1">
          <i class="fa fa-compass mr-1 text-black-50"></i>
          ${data.location}
        </div>` : ``
            }
      </div>
    </div>
    `;
    }
});
