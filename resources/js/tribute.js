import Tribute from "tributejs";

document.addEventListener("turbolinks:load", () => {
  // Users
  var userMention = new Tribute({
    values: (text, cb) => {
      getData(text, (users) => cb(users), "user");
    },
    lookup: (user) => {
      return user.username + user.firstname + user.lastname;
    },
    fillAttr: "username",
    menuShowMinLength: 1,
    menuItemTemplate: (item) => {
      const { avatar, username, firstname, lastname, isVerified } = item.original;
      return `
      <span class="d-flex align-items-center">
        <img class="rounded-circle avatar-30" src="${avatar}" />
        <span class="ml-3">
          <span class="font-weight-bold">
            ${firstname ? firstname : ""} ${lastname ? lastname : ""}
            ${
              isVerified
                ? '<i class="fa fa-check-circle ml-1 mr-1 text-primary"></i>'
                : ""
            }
          </span>
          <span class="d-block text-black-50 font-weight-normal">
            @${username}
          </span>
        </span>
      </span>`;
    },
    noMatchTemplate: () => {
      return "<li>No users Found!</li>";
    },
  });
  
  // Products
  var productsMention = new Tribute({
    values: (text, cb) => {
      getData(text, (products) => cb(products), "product");
    },
    trigger: "#",
    lookup: (product) => {
      return product.slug + product.name;
    },
    fillAttr: "slug",
    menuShowMinLength: 1,
    menuItemTemplate: (item) => {
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
    noMatchTemplate: () => {
      return "<li>No products Found!</li>";
    },
  });
  
  const getData = (text, cb, type) => {
    var URL = type === "user" ? "/mention/users" : "/mention/products";
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = () => {
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
  };

  userMention.attach(document.querySelectorAll(".mentionInput"));
  productsMention.attach(document.querySelectorAll(".mentionInput"));
});
