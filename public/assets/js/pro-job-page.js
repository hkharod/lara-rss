(function () {

  var UTILS = {

    getURLParams: function () {

        function transformToAssocArray(url) {
          var params = {},
            prmarr = url.split("&");

          for (var i = 0; i < prmarr.length; i++) {
            var tmparr = prmarr[i].split("=");
            params[tmparr[0]] = tmparr[1];
          }

          return params;
        }

        var parameters = window.location.search.substr(1);

        return parameters != null && parameters != "" ? transformToAssocArray(parameters) : {};
      }
  };

  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyCikJFYDEFeV9rSMGqf9cdAwPJMHtmnYDU",
    authDomain: "quickleads-club.firebaseapp.com",
    databaseURL: "https://quickleads-club.firebaseio.com",
    projectId: "quickleads-club",
    storageBucket: "quickleads-club.appspot.com",
    messagingSenderId: "1004777651446"
  };

  firebase.initializeApp(config);

  var urlParams = UTILS.getURLParams(),
      proFailEl = document.querySelector("#pro-fail"),
      proSuccessEl = document.querySelector("#pro-success"),
      loadingEl = document.querySelector("#loading"),
      jobHTMLEl  = document.querySelector("#job-html");

  // Checking the k parameter where the pro member key will live.
  if (typeof urlParams.k !== "undefined" && urlParams.k.length >= 1) {

    firebase.database().ref("/proKeys/" + urlParams.k).on("value", function (snapshot) {

      var isAuthorized = snapshot.val(),
          pathNameArray = window.location.pathname.split("/"),
          proJobLocation = pathNameArray[pathNameArray.length - 1];

      // Remove the .html extension incase it's right there still...
      proJobLocation = proJobLocation.replace(/\.[^/.]+$/, "");

      loadingEl.classList.add("hidden");

      if (isAuthorized) {

        proSuccessEl.classList.remove("hidden");

        firebase.database().ref("/proJobs/" + urlParams.k + "/" + proJobLocation).on("value", function (jobSnapshot) {
          jobHTMLEl.innerHTML = jobSnapshot.val();
          proSuccessEl.classList.add("hidden");
        });

      } else {
        proFailEl.classList.remove("hidden");
        return;
      }
    });

  } else {
    proFailEl.classList.remove("hidden");
    loadingEl.classList.add("hidden");
  }

}());
