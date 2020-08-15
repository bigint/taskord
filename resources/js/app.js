require('./bootstrap');
require('./shortcuts');
const Turbolinks = require("turbolinks");
import {isInViewport} from "observe-element-in-viewport";

Turbolinks.start();

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
$(document).on('turbolinks:load', () => {
  $("#admin-bar-click").click('turbolinks:load', () => {
    $.get("/admin/adminbar", (data, status) => {
      if(data === "enabled" || data === "disabled") {
        if (status === "success") {
          location.reload();
        }
      }
    });
  });
});

// Dark mode toggle in dropdown
$(document).on('turbolinks:load', () => {
  $("#dark-mode").click('turbolinks:load', () => {
    $.get("/darkmode", (data, status) => {
      if(data === "enabled" || data === "disabled") {
        if (status === "success") {
          location.reload();
        }
      }
    });
  });
});

// Enable Tooltips
$(document).on('turbolinks:load', () => {
  $("body").tooltip({ selector: '[data-toggle=tooltip]' });
});

// Hide Alert
$(document).on("livewire:load", (_event) => {
  window.livewire.hook('afterDomUpdate', () => {
    setTimeout(() => {
      $('.fade').fadeOut('fast');
    }, 2000);
  });
});

$(document).on("livewire:load", (_event) => {
  $('#task-input').keyup( () => {
    const max = 300;
    const len = $(this).val().length;

    if (len >= max) {
      $('#task-len-counter').text('You have reached the limit').addClass('text-danger');
    } else {
      const char = max - len;
      $('#task-len-counter').text(`${char} characters left`);
    }

    $('#task-len-counter').removeClass('text-danger');
  });
});

// Hide search dropdown on clicking the body
$("body").on("click", (_event) => {
  $("ul").remove(".search-dropdown");
});
