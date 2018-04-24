(function () {

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

  var userObj = {};
      userObj.tags = [],
      carousel = document.querySelector('.js-carousel'),
      form = document.querySelector('.js-form'),
      submitButton = document.querySelector('.js-submit'),
      text = document.querySelector('.js-text'),
      checkboxes = document.querySelectorAll(".js-checkbox"),
      thankYou = document.querySelector(".js-thankyou"),
      thankYouName = document.querySelector(".js-thankyou-name"),
      closeButton = document.querySelector(".js-close"),
      proFlowEl = document.getElementById("PROFLOW"),
      cardErrors = document.getElementById("card-errors");


  var DRIP = {
    identifyUser: function (userData) {
      _dcq.push(["identify", userData]);
    },

    subscribeToCampaign: function (userData) {
      var obj = {};
      obj.campaign_id = '964017088';
      obj.fields = userData;

      _dcq.push(["subscribe", obj]);
    }
  };

  if ( document.body.contains(form)) {
    form.addEventListener('submit', function (event) {

      var emailsRef = firebase.database().ref("emails");

      event.preventDefault();
      submitButton.blur();

      userObj.email = document.getElementById("email").value;
      userObj.first_name = document.getElementById("first_name").value;
      userObj.prospect = true;

      thankYouName.innerHTML = userObj.first_name;
      thankYou.className += ' show';

      DRIP.identifyUser(userObj);
      DRIP.subscribeToCampaign(userObj);

      emailsRef.push().set({
        "email": userObj.email,
        "first_name": userObj.first_name
      });

    });

  }

  if ( document.body.contains(closeButton)) {
    closeButton.addEventListener("click", function () {
      thankYou.parentElement.removeChild(thankYou);
    });
  }

  if (document.body.contains(proFlowEl)) {

    // Set up the payment flow
    var stripe = Stripe('pk_live_0vCjjJg9YHgukOPNc7Jq9Bki');
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    var style = {
      base: {
        // Add your base input styles here. For example:
        border: '1px solid #D8D8D8',
        borderRadius: '4px',
        color: "#000",
      }
    };

    // Create an instance of the card Element
    var card,
        paymentKey,
        jobKey;

    var PROFLOW = new Vue({
      el: "#PROFLOW",

      data: {

        firstName: "",
        requiredSkills: "",
        shortDescription: "",
        longDescription: "",
        positionType: "",
        learnMoreLink: "",
        projectDuration: "",

        errorMessage: "",
        email: "",
        checkedTechnologies: [], // The type of leads that the user wants to receive.

        nextStep: false,
        cardErrorMessage: undefined,
        hasCardError: false,

        currentlyPaying: false,
        hasPaymentToken: false,

        paymentStatus: "",
        paymentStatusMessage: "",

        paymentProcessed: false,

        paymentProcessedSuccessfully: false,

        paymentModalIsClosed: true,

        subscriptionType: ""
      },

      created: function () {

        var self = this;

        var subscriptionType = document.getElementById("PROFLOW").getAttribute("data-subscription-type");

        self.subscriptionType = subscriptionType;

        // So there's no flash initially when vue is interpreting the HTML.
        document.querySelector(".vue-is-loading").classList.remove("vue-is-loading");

        var urlParams = UTILS.getURLParams();

        for (var prop in urlParams) {

          if (typeof urlParams[prop] !== "undefined" && urlParams[prop].length >=1 && typeof self[prop] !== "undefined") {
            console.log("prop", prop);
            self[prop] = decodeURIComponent(urlParams[prop]);
          }
        }

      },

      mounted: function () {

        card = elements.create('card', {style: style});

        var self = this;

        // Add an instance of the card Element into the `card-element` <div>
        card.mount('#card-element');

        card.addEventListener('change', (event) => {

          if (event.error) {
            this.cardErrorMessage = event.error.message;
            this.hasCardError = true;
          } else {
            this.cardErrorMessage = undefined;
            this.hasCardError = false;
          }

          this.$forceUpdate();

        });

        firebase.database().ref("paymentStatus").on("child_added", function (snapshot) {

          var snapshotKey = snapshot.key,
              value = snapshot.val();

          // Make sure we're dealing with the right payment.
          if (typeof paymentKey !== "undefined" && paymentKey === snapshotKey) {

            self.paymentProcessed = true;

            // Update the button
            if (value.status === 'success') {

              self.paymentStatus = 'Success';
              self.paymentStatusMessage = 'Your payment successfully processed!';

              self.paymentProcessedSuccessfully = true;
              self.currentlyPaying = false;

            } else if (value.status === 'failed') {

              self.paymentStatus = 'Error';
              self.paymentStatusMessage = "Error message from Stripe: " + value.message;

              self.paymentProcessedSuccessfully = false;

              self.currentlyPaying = false;

            }

          }

        });

      },

      methods: {

        previewLinkClick: function (event) {
          event.preventDefault();
        },

        hasAllRequiredFieldsFilled: function () {

          var data = [this.firstName, this.requiredSkills, this.shortDescription, this.positionType ],
              results = true;

          Object.keys(data).forEach(function (prop, value) {

            if (typeof data[prop] === "undefined" || data[prop].length < 1) {
              results = false;
            }

          });

          if ( this.positionType === 'Freelance') {

            if (typeof this.projectDuration === 'undefined') {
              results = false;
            }

          }

          return results;

        },

        purchase: function () {

          var self = this;

          if ( ! this.hasAllRequiredFieldsFilled()) {
            self.currentlyPaying = false;
            self.errorMessage = "Don't forget to fill in all required fields.";

            self.$forceUpdate();

            return false;
          } else {
            self.errorMessage = "";

            // Save the data

            // Save the token into firebase.
            var proRef = firebase.database().ref("jobs"),
                proPushItem = proRef.push();

            jobKey = proPushItem.key;

            var proObj = {
              firstName: self.firstName,
              requiredSkills: self.requiredSkills,
              shortDescription: self.shortDescription,
              longDescription: self.longDescription,
              positionType: self.positionType,
              learnMoreLink: self.learnMoreLink,
              projectDuration: self.projectDuration,
            };

            proPushItem.set(proObj);

          }

          self.currentlyPaying = true;

          self.paymentStatus = '';
          self.paymentStatusMessage = '';
          self.paymentProcessedSuccessfully = false;
          self.paymentProcessed = false;

          console.log("About to call stripe.createToken");

          stripe.createToken(card).then(function(result) {

            if (result.error) {

              self.currentlyPaying = false;

              self.cardErrorMessage = result.error.message;
              self.hasCardError = true;

              self.$forceUpdate();

              return;
            }

            if (result.token) {

              self.hasPaymentToken = true;
              self.paymentModalIsClosed = false;

              setTimeout(function () {
                window.scrollTo(0, 0);
              }, 0);


              // Save the token into firebase.
              var chargesRef = firebase.database().ref("charges"),
                  chargePushItem = chargesRef.push();

              chargePushItem.set({
                "token": result.token,
                "email": self.email
              });

              paymentKey = chargePushItem.key;

            }

          });

        },

        closePaymentModal: function (event) {

          event.preventDefault();
          this.paymentModalIsClosed = true;

        },

        hasTechnology: function (technology) {
          return this.checkedTechnologies.includes(technology);
        }

      }
    });

  }

}());
