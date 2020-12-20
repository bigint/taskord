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
        <img loading=lazy class="rounded-circle avatar-30" src="${avatar}" />
        <span class="ms-3">
          <span class="fw-bold">
            ${firstname ? firstname : ""} ${lastname ? lastname : ""}
            ${
              isVerified
                ? `
                <svg style="vertical-align: sub; width: 17px; height: 17px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#6a63ec">
                  <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                `
                : ""
            }
          </span>
          <span class="d-block text-secondary fw-normal">
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
        <img loading=lazy class="rounded avatar-30" src="${avatar}" />
        <span class="ms-3">
          <span class="fw-bold">
            ${name}
          </span>
          <span class="d-block text-secondary fw-normal">
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
