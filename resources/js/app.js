require('./bootstrap');
require('./shortcuts');
import {isInViewport} from "observe-element-in-viewport";
import lightbox from 'lightbox2/dist/js/lightbox';
import Tribute from "tributejs";

// Tribute
var tribute = new Tribute({
  values: function (text, cb) {
    remoteSearch(text, users => cb(users));
  },
  lookup: function (user) {
    return user.username + user.firstname + user.lastname;
  },
  fillAttr: 'username',
  menuShowMinLength: 1,
  menuItemTemplate: function (item) {
    const { avatar, username, firstname, lastname } = item.original;
    return `
    <span class="d-flex align-items-center">
      <img class="rounded-circle avatar-20" src="${avatar}" />
      <span class="ml-3">
        <span class="font-weight-bold">
          ${firstname ? firstname : ''} ${lastname ? lastname : ''}
        </span>
        <span class="small text-black-50 font-weight-normal">
          @${username}
        </span>
      </span>
    </span>`;
  },
  noMatchTemplate: function () {
    return '<li>No users Found!</li>';
  },
});

function remoteSearch(text, cb) {
  var URL = "/mention";
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        var data = JSON.parse(xhr.responseText);
        cb(data);
      } else if (xhr.status === 403) {
        cb([]);
      }
    }
  };
  xhr.open("GET", URL + "?query=" + text, true);
  xhr.send();
}

tribute.attach(document.getElementById('mentionInput'));

window.lightbox = lightbox;
window.lightbox.option({
  disableScrolling: true,
  fadeDuration: 100,
  imageFadeDuration: 100,
  resizeDuration: 300,
  fitImagesInViewport: true,
  maxWidth: 1000,
});

$(document).ready(() => {
  (async () => {
    const target = document.querySelector('#load-more');
    if (await isInViewport(target)) {
      $("#load-more").click();
      $("#load-more").html("Loading");
      $("#load-more").prop('disabled', true);
    }
  })();
});

$(window).scroll(() => {
  if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
    $("#load-more").click();
    $("#load-more").html("Loading");
    $("#load-more").prop('disabled', true);
  }
});

// Admin Bar toggle in dropdown
$("#admin-bar-click").click(() => {
  $.get("/admin/adminbar", (data, status) => {
    if(data === "enabled" || data === "disabled") {
      if (status === "success") {
        location.reload();
      }
    }
  });
});

// Dark mode toggle in dropdown
$("#dark-mode").click(() => {
  $.get("/darkmode", (data, status) => {
    if(data === "enabled" || data === "disabled") {
      if (status === "success") {
        location.reload();
      }
    }
  });
});

// Hide Alert
$(document).on("livewire:load", (_event) => {
  window.Livewire.hook('element.updated', () => {
    setTimeout(() => {
      $('.fade').fadeOut('fast');
    }, 2000);
  });
});

// Hide search dropdown on clicking the body
$("body").on("click", (_event) => {
  $("ul").remove(".search-dropdown");
});
