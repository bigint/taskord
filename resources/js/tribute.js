import Tribute from "tributejs";


// Users
var userMention = new Tribute({
  values: function (text, cb) {
    getUsers(text, users => cb(users));
  },
  lookup: function (user) {
    return user.username + user.firstname + user.lastname;
  },
  fillAttr: 'username',
  menuShowMinLength: 1,
  menuItemTemplate: function (item) {
    const { avatar, username, firstname, lastname, isVerified } = item.original;
    return `
    <span class="d-flex align-items-center">
      <img class="rounded-circle avatar-30" src="${avatar}" />
      <span class="ml-3">
        <span class="font-weight-bold">
          ${firstname ? firstname : ''} ${lastname ? lastname : ''}
          ${isVerified ? '<i class="fa fa-check-circle ml-1 mr-1 text-primary"></i>' : ''}
        </span>
        <span class="d-block text-black-50 font-weight-normal">
          @${username}
        </span>
      </span>
    </span>`;
  },
  noMatchTemplate: function () {
    return '<li>No users Found!</li>';
  },
});

function getUsers(text, cb) {
  var URL = "/mention/users";
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

userMention.attach(document.getElementById('mentionInput'));

// Products
var productsMention = new Tribute({
  values: function (text, cb) {
    getProducts(text, users => cb(users));
  },
  trigger: '#',
  lookup: function (product) {
    return product.slug + product.name;
  },
  fillAttr: 'slug',
  menuShowMinLength: 1,
  menuItemTemplate: function (item) {
    const { avatar, slug, name } = item.original;
    return `
    <span class="d-flex align-items-center">
      <img class="rounded avatar-30" src="${avatar}" />
      <span class="ml-3">
        <span class="font-weight-bold">
          ${name}
        </span>
        <span class="d-block text-black-50 font-weight-normal">
          #${slug}
        </span>
      </span>
    </span>`;
  },
  noMatchTemplate: function () {
    return '<li>No users Found!</li>';
  },
});

function getProducts(text, cb) {
  var URL = "/mention/products";
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

productsMention.attach(document.getElementById('mentionInput'));
